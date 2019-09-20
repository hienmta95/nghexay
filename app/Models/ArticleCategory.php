<?php


namespace App\Models;

use App\Models\Scopes\ActiveScope;
use App\Models\Traits\TranslatedTrait;
use App\Observer\ArticleCategoryObserver;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Icetea\Admin\app\Models\Crud;
use Prologue\Alerts\Facades\Alert;

class ArticleCategory extends BaseModel
{
	use Crud, Sluggable, SluggableScopeHelpers, TranslatedTrait;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'article_categories';

	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	// protected $primaryKey = 'id';
	protected $appends = ['tid'];

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var boolean
	 */
	public $timestamps = false;

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
		'parent_id',
		'name',
		'slug',
		'description',
		'picture',
		'icon_class',
		'active',
		'lft',
		'rgt',
		'depth',
		'translation_lang',
		'translation_of',
	];
	public $translatable = ['name', 'slug', 'description'];

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
	// protected $dates = [];

	/*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/
	protected static function boot()
	{
		parent::boot();

		ArticleCategory::observe(ArticleCategoryObserver::class);

		static::addGlobalScope(new ActiveScope());
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
				'source' => 'slug_or_name',
			],
		];
	}

	public function getNameHtml()
	{
		$currentUrl = preg_replace('#/(search)$#', '', url()->current());
		$url = $currentUrl . '/' . $this->id . '/edit';

		$out = '<a href="' . $url . '">' . $this->name . '</a>';

		return $out;
	}

	public function subCategoriesBtn($xPanel = false)
	{
		$out = '';

		if ($this->parent_id == 0) {
			$url = admin_url('article-categories/' . $this->id . '/subcategories');

			$msg = trans('admin::messages.Subcategories of :category', ['category' => $this->name]);
			$tooltip = ' data-toggle="tooltip" title="' . $msg . '"';

			$out .= '<a class="btn btn-xs btn-default" href="' . $url . '"' . $tooltip . '>';
			$out .= '<i class="fa fa-eye"></i> ';
			$out .= mb_ucfirst(trans('admin::messages.subcategories'));
			$out .= '</a>';
		}

		return $out;
	}

	/*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
	public function posts()
	{
		return $this->hasManyThrough(Article::class, ArticleCategory::class, 'parent_id', 'category_id');
	}

	public function children()
	{
		return $this->hasMany(ArticleCategory::class, 'parent_id', 'translation_of')->where('translation_lang', config('app.locale'));
	}

	public function lang()
	{
		return $this->hasOne(ArticleCategory::class, 'translation_of', 'abbr');
	}

	public function parent()
	{
		return $this->belongsTo(ArticleCategory::class, 'parent_id', 'translation_of')->where('translation_lang', config('app.locale'));
	}

	/*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/

	/*
	|--------------------------------------------------------------------------
	| ACCESORS
	|--------------------------------------------------------------------------
	*/
	// The slug is created automatically from the "title" field if no slug exists.
	public function getSlugOrNameAttribute()
	{
		if ($this->slug != '') {
			return $this->slug;
		}
		return $this->name;
	}

	/**
	 * ArticleCategory icons pictures from original version
	 * Only the file name is set in ArticleCategory 'picture' field
	 * Example: fa-car.png
	 *
	 * @return null|string
	 */
	public function getPictureFromOriginPath()
	{
		$skin = config('settings.style.app_skin', 'skin-default');

		if (!isset($this->attributes) || !isset($this->attributes['picture'])) {
			return null;
		}

		$value = $this->attributes['picture'];
		if (empty($value)) {
			return null;
		}

		// Fix path
		$value = 'app/categories/' . $skin . '/' . $value;

		if (!Storage::exists($value)) {
			$value = null;
		}

		return $value;
	}

	public function getPictureAttribute()
	{
		$skin = getFrontSkin(request()->input('skin'));

		// OLD PATH
		$value = $this->getPictureFromOriginPath();
		if (!empty($value)) {
			return $value;
		}

		// NEW PATH
		if (!isset($this->attributes) || !isset($this->attributes['picture'])) {
			$value = 'app/default/article-categories/fa-folder-' . $skin . '.png';
			return $value;
		}

		$value = $this->attributes['picture'];

		if (!Storage::exists($value)) {
			$value = 'app/default/article-categories/fa-folder-' . $skin . '.png';
		} else {
			// If the ArticleCategory contains a skinnable icon,
			// Change it by the selected skin icon.
			if (str_contains($value, 'app/categories/skin-')) {
				$pattern = '/app\/article-categories\/skin-[^\/]+\//iu';
				$replacement = 'app/article-categories/' . $skin . '/';
				$value = preg_replace($pattern, $replacement, $value);
			}

			// (Optional)
			// If the ArticleCategory contains a skinnable defalt icon,
			// Change it by the selected skin default icon.
			if (str_contains($value, 'app/default/article-categories/fa-folder-')) {
				$pattern = '/app\/default\/article-categories\/fa-folder-[^\.]+\./iu';
				$replacement = 'app/default/article-categories/fa-folder-' . $skin . '.';
				$value = preg_replace($pattern, $replacement, $value);
			}
		}

		return $value;
	}

	/*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
	public function setPictureAttribute($value)
	{
		$skin = config('settings.style.app_skin', 'skin-default');
		$attribute_name = 'picture';
		$destination_path = 'app/categories/custom';

		// If the image was erased
		if (empty($value)) {
			// Don't delete the default pictures
			$defaultPicture = 'app/default/article-categories/fa-folder-' . $skin . '.png';
			$defaultSkinPicture = 'app/article-categories/' . $skin . '/';
			if (!str_contains($this->picture, $defaultPicture) && !str_contains($this->picture, $defaultSkinPicture)) {
				// delete the image from disk
				Storage::delete($this->picture);
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

				// Make the image
				$image = Image::make($value)->resize(400, 400, function ($constraint) {
					$constraint->aspectRatio();
				});

				// Generate a filename.
				$filename = md5($value . time()) . '.' . $extension;

				// Store the image on disk.
				Storage::put($destination_path . '/' . $filename, $image->stream());

				// Save the path to the database
				$this->attributes[$attribute_name] = $destination_path . '/' . $filename;
			} else {
				// Retrieve current value without upload a new file.
				if (str_contains($value, 'app/default/') || empty($value)) {
					$value = null;
				} else {
					// Common path includes 'app/categories/custom/' and 'app/categories/skin-*/' paths
					$commonPath = 'app/categories/';
					if (!starts_with($value, $commonPath)) {
						$value = $commonPath . last(explode($commonPath, $value));
					}
				}
				$this->attributes[$attribute_name] = $value;
			}
		} catch (\Exception $e) {
			Alert::error($e->getMessage())->flash();
			$this->attributes[$attribute_name] = null;

			return false;
		}
	}

	/**
	 * Activate/Deactivate categories with their children if exist
	 * Activate/Deactivate translated entries with their translations if exist
	 * @param $value
	 */
	public function setActiveAttribute($value)
	{
		$entityId = (isset($this->attributes['id'])) ? $this->attributes['id'] : null;

		if (!empty($entityId)) {
			// Activate the entry
			$this->attributes['active'] = $value;

			// If the entry is a parent entry, activate its children
			$parentId = (isset($this->attributes['parent_id'])) ? $this->attributes['parent_id'] : null;
			if ($parentId == 0) {
				// ... AND don't select the current parent entry to prevent infinite recursion
				$entries = $this->where('parent_id', $entityId)->get();
				if (!empty($entries)) {
					foreach ($entries as $entry) {
						$entry->active = $value;
						$entry->save();
					}
				}
			}
		} else {
			// Activate the new entries
			$this->attributes['active'] = $value;
		}
	}
}
