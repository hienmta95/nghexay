<?php


namespace App\Models;

use App\Models\Scopes\ActiveScope;
use App\Models\Scopes\LocalizedScope;
use App\Observer\ProfileObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Icetea\Admin\app\Models\Crud;

class Profile extends Model
{
    //use Crud;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_profiles';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

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
    //protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'code',
        'name',
        'visits',
        'education_data',
        'edu_type_id',
        'skill_data',
        'expected_job_data',
        'experience_data',
        'experience_years',
        'expected_job_title',
        'expected_job_category_id',
        'expected_job_position_id',
        'expected_job_city_id',
        'expected_job_salary',
        'expected_job_post_type_id',
        'other',
        'active',
        'category_id',
        'point'
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
    protected $dates = ['created_at', 'updated_at'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();

        Profile::observe(ProfileObserver::class);
        //static::addGlobalScope(new ActiveScope());
        //static::addGlobalScope(new LocalizedScope());
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */


    public function category()
    {
        return $this->belongsTo(Category::class, 'expected_job_category_id', 'id');
    }


    public function getPoint()
    {
        $count = 0;
        $point = 1;
        if ($this->education_data != null) {
            $count++;
        }
        if ($this->skill_data != null) {
            $count++;
        }
        if ($this->experience_data != null) {
            $count++;
        }
        if ($this->expected_job_data != null) {
            $count++;
        }

        if ($count >= 2) {
            $point = 2;
        }
        //$exjob = json_decode($this->expected_job_data);

        if ($this->expected_job_position_id == 8) {
            $point++;
        }
        $this->point = $point;
        $this->save();
        return $point;
    }

    public function getProfileCode(){
        if($this->code != null){
            return $this->code;
        }
        $expectedJobCat = $this->expected_job_category_id != null ? Category::find($this->expected_job_category_id) : null;

        if($expectedJobCat){
            $parts = explode(' ',$expectedJobCat->name);
            $initials = '';
            foreach($parts as $part) {
                $initials .= $part[0];
            }

            $prefix = $expectedJobCat != null ? strtoupper($initials) : 'GC';

        }else{
            $prefix = 'GC';
        }
        $numbers = 1000000+$this->user_id;
        $code =  $prefix.$numbers;
        $this->code = $code;
        $this->save();
        return $code;
    }
    public function getOnlineResume(){
        $candidate = $this->user;
        $profile = $this;
        $folderpath = 'resumes/'.strtolower(config('country.code')).'/'.$candidate->id.'/';
        if(!\Storage::exists($folderpath)){
            \Storage::makeDirectory($folderpath);
        }
        $filename = str_slug($candidate->name) . '-online.pdf';
        $filepath =$folderpath.$filename;

        if(\Storage::exists($filepath)){
            \Storage::delete($filepath);
        }
        $pdf = \PDF::loadView('search.candidate.profile-pdf', compact('candidate','profile'));
        $pdf->save(\Storage::path($filepath));

        $resumeInfo = [
            'country_code' => config('country.code'),
            'user_id'      => $candidate->id,
            'is_online_resume' => 1,
            'active'       => 1,
        ];

        //dd($filepath);

        $resume = Resume::firstOrCreate($resumeInfo);
        $resume->filename = $filepath;
        $resume->name = 'CV '. $candidate->name . ' Online';
        //dd($filepath);
        $resume->save();

        return $resume;
    }


}
