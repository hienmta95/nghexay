<?php


namespace App\Models;

use App\Models\Scopes\FromActivatedCategoryScope;
use App\Models\Scopes\LocalizedScope;
use App\Models\Scopes\VerifiedScope;
use App\Models\Scopes\ReviewedScope;
use App\Models\Traits\CountryTrait;
use App\Observer\ArticleObserver;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Jenssegers\Date\Date;
use Icetea\Admin\app\Models\Crud;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Article extends BaseModel implements Feedable
{
    use Crud, Sluggable, SluggableScopeHelpers;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    protected $appends = ['uri', 'created_at_ta'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = true;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_code',
        'user_id',
        'logo',
        'category_id',
        'title',
        'slug',
        'description',
        'tags',
        'visits',
        'published',
        'featured',
        'archived',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays
     *
     * @var array
     */
    // protected $hidden = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();

        Article::observe(ArticleObserver::class);

        static::addGlobalScope(new FromActivatedCategoryScope());
        //static::addGlobalScope(new ReviewedScope());
        static::addGlobalScope(new LocalizedScope());
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title_or_slug',
            ],
        ];
    }


    public static function getFeedItems()
    {
        $articlesPerPage = (int)config('settings.listing.items_per_page', 50);

        if (
            request()->has('d')
            || config('plugins.domainmapping.installed')
        ) {
            $countryCode = config('country.code');
            if (!config('plugins.domainmapping.installed')) {
                if (request()->has('d')) {
                    $countryCode = request()->input('d');
                }
            }

            $articles = Article::where('country_code', $countryCode)
                ->unarchived()
                ->take($articlesPerPage)
                ->orderByDesc('id')
                ->get();
        } else {
            $articles = Article::unarchived()->take($articlesPerPage)->orderByDesc('id')->get();
        }

        return $articles;
    }

    public function toFeedItem()
    {
        $title = $this->title;
        $title .= (isset($this->country) && !empty($this->country)) ? ', ' . $this->country->name : '';
        // $summary = str_limit(str_strip(strip_tags($this->description)), 5000);
        $summary = transformDescription($this->description);
        $link = config('app.locale') . '/' . $this->uri;

        return FeedItem::create()
            ->id($link)
            ->title($title)
            ->summary($summary)
            ->updated($this->updated_at)
            ->link($link)
            ->author($this->contact_name);
    }

    public function getTitleHtml()
    {
        $article = self::find($this->id);

        return getArticleUrl($article);
    }

    public function getUrl()
    {
        return \route('article.detail', $this->slug);
    }

    public function getLogoHtml()
    {
        $style = ' style="width:auto; max-height:90px;"';

        // Get logo
        $out = '<img src="' . resize($this->logo, 'small') . '" data-toggle="tooltip" title="' . $this->title . '"' . $style . '>';

        // Add link to the Ad
        $url = localUrl($this->country_code, $this->uri);
        $out = '<a href="' . $url . '" target="_blank">' . $out . '</a>';

        return $out;
    }

    /*public function getPictureHtml()
    {
        // Get ad URL
        $url = url(config('app.locale') . '/' . $this->uri);

        $style = ' style="width:auto; max-height:90px;"';
        // Get first picture
        if ($this->pictures->count() > 0) {
            foreach ($this->pictures as $picture) {
                $url = localUrl($picture->article->country_code, $this->uri);
                $out = '<img src="' . resize($picture->filename, 'small') . '" data-toggle="tooltip" title="' . $this->title . '"' . $style . '>';
                break;
            }
        } else {
            // Default picture
            $out = '<img src="' . resize(config('icetea.core.picture.default'), 'small') . '" data-toggle="tooltip" title="' . $this->title . '"' . $style . '>';
        }

        // Add link to the Ad
        $out = '<a href="' . $url . '" target="_blank">' . $out . '</a>';

        return $out;
    }*/


    public function getReviewedHtml()
    {
        return ajaxCheckboxDisplay($this->{$this->primaryKey}, $this->getTable(), 'published', $this->published);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id', 'translation_of')->where('translation_lang', config('app.locale'));
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */


    public function scopePublished($builder)
    {
        return $builder->where('published', 1);
    }

    public function scopeUnpublished($builder)
    {
        return $builder->where('published', 0);
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function getCreatedAtAttribute($value)
    {
        $value = Date::parse($value);
        if (config('timezone.id')) {
            $value->timezone(config('timezone.id'));
        }
        //echo $value->format('l d F Y H:i:s').'<hr>'; exit();
        //echo $value->formatLocalized('%A %d %B %Y %H:%M').'<hr>'; exit(); // Multi-language

        return $value;
    }

    public function getUpdatedAtAttribute($value)
    {
        $value = Date::parse($value);
        if (config('timezone.id')) {
            $value->timezone(config('timezone.id'));
        }

        return $value;
    }

    public function getDeletedAtAttribute($value)
    {
        $value = Date::parse($value);
        if (config('timezone.id')) {
            $value->timezone(config('timezone.id'));
        }

        return $value;
    }

    public function getCreatedAtTaAttribute($value)
    {
        $value = Date::parse($this->attributes['created_at']);
        if (config('timezone.id')) {
            $value->timezone(config('timezone.id'));
        }
        $value = $value->ago();

        return $value;
    }


    public function getUriAttribute($value)
    {
        $value = trans('routes.v-article', [
            'slug' => slugify($this->attributes['title']),
            'id' => $this->attributes['id'],
        ]);

        return $value;
    }

    public function getTitleAttribute($value)
    {
        return mb_ucfirst($value);
    }


    public function getLogoFromOldPath()
    {
        if (!isset($this->attributes) || !isset($this->attributes['logo'])) {
            return null;
        }

        $value = $this->attributes['logo'];

        // Fix path
        $value = str_replace('uploads/pictures/', '', $value);
        $value = str_replace('pictures/', '', $value);
        $value = 'pictures/' . $value;

        if (!Storage::exists($value)) {
            $value = null;
        }

        return $value;
    }

    public function getLogoAttribute()
    {
        // OLD PATH
        $value = $this->getLogoFromOldPath();
        if (!empty($value)) {
            return $value;
        }

        // NEW PATH
        if (!isset($this->attributes) || !isset($this->attributes['logo'])) {
            $value = config('icetea.core.picture.default');
            return $value;
        }

        $value = $this->attributes['logo'];

        if (!Storage::exists($value)) {
            $value = config('icetea.core.picture.default');
        }

        return $value;
    }

    public static function getLogo($value)
    {
        // OLD PATH
        $value = str_replace('uploads/pictures/', '', $value);
        $value = str_replace('pictures/', '', $value);
        $value = 'pictures/' . $value;
        if (Storage::exists($value) && substr($value, -1) != '/') {
            return $value;
        }

        // NEW PATH
        $value = str_replace('pictures/', '', $value);
        if (!Storage::exists($value) && substr($value, -1) != '/') {
            $value = config('icetea.core.picture.default');
        }

        return $value;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setLogoAttribute($value)
    {
        $attribute_name = 'logo';

        // Don't make an upload for Article->logo for logged users
        if (!str_contains(Route::currentRouteAction(), 'Admin\ArticleController')) {
            if (auth()->check()) {
                $this->attributes[$attribute_name] = $value;

                return $this->attributes[$attribute_name];
            }
        }

        if (!isset($this->country_code) || !isset($this->id)) {
            $this->attributes[$attribute_name] = null;

            return false;
        }

        // Path
        $destination_path = 'files/articles/' . strtolower($this->country_code) . '/' . $this->id;

        // If the image was erased
        if (empty($value)) {
            // delete the image from disk
            if (!str_contains($this->{$attribute_name}, config('icetea.core.picture.default'))) {
                Storage::delete($this->{$attribute_name});
            }

            // set null in the database column
            $this->attributes[$attribute_name] = null;

            return false;
        }

        // Check the image file
        if ($value == url('/')) {
            $this->attributes[$attribute_name] = null;

            return false;
        }

        // If laravel request->file('filename') resource OR base64 was sent, store it in the db
        try {
            if (fileIsUploaded($value)) {
                // Get file extension
                $extension = getUploadedFileExtension($value);
                if (empty($extension)) {
                    $extension = 'jpg';
                }

                // Make the image (Size: 454x454)
                $image = Image::make($value)->resize(640, 320, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode($extension, config('icetea.core.picture.quality', 100));

                // Generate a filename.
                $filename = md5($value . time()) . '.' . $extension;

                // Store the image on disk.
                Storage::put($destination_path . '/' . $filename, $image->stream());

                // Save the path to the database
                $this->attributes[$attribute_name] = $destination_path . '/' . $filename;

                return $this->attributes[$attribute_name];
            } else {
                // Retrieve current value without upload a new file.
                if (starts_with($value, config('icetea.core.logo'))) {
                    $value = null;
                } else {
                    // Extract the value's country code
                    $tmp = [];
                    preg_match('#files/([A-Za-z]{2})/[\d]+#i', $value, $tmp);
                    $valueCountryCode = (isset($tmp[1]) && !empty($tmp[1])) ? $tmp[1] : null;

                    // Extract the value's ID
                    $tmp = [];
                    preg_match('#files/[A-Za-z]{2}/([\d]+)#i', $value, $tmp);
                    $valueId = (isset($tmp[1]) && !empty($tmp[1])) ? $tmp[1] : null;

                    // Extract the value's filename
                    $tmp = [];
                    preg_match('#files/[A-Za-z]{2}/[\d]+/(.+)#i', $value, $tmp);
                    $valueFilename = (isset($tmp[1]) && !empty($tmp[1])) ? $tmp[1] : null;

                    if (!empty($valueCountryCode) && !empty($valueId) && !empty($valueFilename)) {
                        // Value's Path
                        $valueDestinationPath = 'files/' . strtolower($valueCountryCode) . '/' . $valueId;
                        if ($valueDestinationPath != $destination_path) {
                            $oldFilePath = $valueDestinationPath . '/' . $valueFilename;
                            $newFilePath = $destination_path . '/' . $valueFilename;

                            // Copy the file
                            Storage::copy($oldFilePath, $newFilePath);

                            $this->attributes[$attribute_name] = $newFilePath;

                            return $this->attributes[$attribute_name];
                        }
                    }

                    if (!starts_with($value, 'files/')) {
                        $value = $destination_path . last(explode($destination_path, $value));
                    }
                }
                $this->attributes[$attribute_name] = $value;

                return $this->attributes[$attribute_name];
            }
        } catch (\Exception $e) {
            flash($e->getMessage())->error();
            $this->attributes[$attribute_name] = null;

            return false;
        }
    }

    public function setTagsAttribute($value)
    {
        $this->attributes['tags'] = (!empty($value)) ? mb_strtolower($value) : $value;
    }


    public function getSlug()
    {
        $slug  = ($this->slug  != null) ? $this->slug : str_slug($this->title);
        if($this->slug == null) {

            $this->slug = $slug;
            $this->save();
        }
        return $slug;
    }
}
