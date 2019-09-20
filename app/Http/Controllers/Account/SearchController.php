<?php


namespace App\Http\Controllers\Account;

use App\Http\Controllers\Auth\Traits\VerificationTrait;
use App\Http\Requests\UserRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\EducationType;
use App\Models\PositionType;
use App\Models\PostType;
use App\Models\Profile;
use App\Models\Resume;
use App\Models\SavedCandidate;
use App\Models\Scopes\VerifiedScope;
use App\Models\SkillType;
use App\Models\UserType;
use Creativeorange\Gravatar\Facades\Gravatar;
use App\Models\Post;
use App\Models\SavedPost;
use App\Models\Gender;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends AccountBaseController
{
    use VerificationTrait;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Get all User's Companies
        //$companies = $this->companies->paginate($this->perPage);
        $currentUser = auth()->user();
        if ($currentUser->user_type_id == 1) {
            return $this->employerIndex();
        } else {
            return $this->candidateIndex();
        }
    }


    private function candidateIndex()
    {
        $data = [];
        $currentUser = auth()->user();

        $data['countries'] = CountryLocalizationHelper::transAll(CountryLocalization::getCountries());
        $data['genders'] = Gender::trans()->get();
        $data['userTypes'] = UserType::all();
        $data['skillTypes'] = SkillType::trans()->get();
        $data['educationTypes'] = EducationType::trans()->get();
        $data['positionTypes'] = PositionType::trans()->get();
        $data['postTypes'] = PostType::trans()->get();
        $data['categories'] = Category::trans()->get();
        $data['cities'] = City::where('country_code', 'VN')
            ->where('feature_class','P')
            ->orderBy('sort', 'desc')
            ->where('active',1)->get();

        $data['gravatar'] = (!empty(auth()->user()->email)) ? Gravatar::fallback(url('images/user.jpg'))->get(auth()->user()->email) : null;

        // Mini Stats
        $data['countPostsVisits'] = DB::table('posts')
            ->select('user_id', DB::raw('SUM(visits) as total_visits'))
            ->where('country_code', config('country.code'))
            ->where('user_id', auth()->user()->id)
            ->groupBy('user_id')
            ->first();

        $data['countPosts'] = Post::currentCountry()
            ->where('user_id', auth()->user()->id)
            ->count();

        $data['countFavoritePosts'] = SavedPost::whereHas('post', function ($query) {
            $query->currentCountry();
        })->where('user_id', $currentUser->id)
            ->count();


        // Meta Tags
        MetaTag::set('title', t('Dashboard'));
        MetaTag::set('description', t('Dashboard - :app_name', ['app_name' => config('settings.app.app_name')]));


        return view('account.candidate-search-index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function employerIndex()
    {

        $currentUser = auth()->user();
        $params = request()->all();

        $data['countries'] = CountryLocalizationHelper::transAll(CountryLocalization::getCountries());
        $data['genders'] = Gender::trans()->get();
        $data['userTypes'] = UserType::all();
        $data['skillTypes'] = SkillType::trans()->get();
        $data['educationTypes'] = EducationType::trans()->get();
        $data['positionTypes'] = PositionType::trans()->get();
        $data['postTypes'] = PostType::trans()->get();
        $data['categories'] = Category::trans()->get();
        $data['cities'] = City::where('country_code', 'VN')->where('feature_class','P')
            ->orderBy('population','desc')->orderBy('name', 'asc')->get();
        $data['gravatar'] = (!empty(auth()->user()->email)) ? Gravatar::fallback(url('images/user.jpg'))->get(auth()->user()->email) : null;

        // Mini Stats
        $data['countPostsVisits'] = DB::table('posts')
            ->select('user_id', DB::raw('SUM(visits) as total_visits'))
            ->where('country_code', config('country.code'))
            ->where('user_id', auth()->user()->id)
            ->groupBy('user_id')
            ->first();
        $data['countPosts'] = Post::currentCountry()
            ->where('user_id', auth()->user()->id)
            ->count();
        $data['countFavoritePosts'] = SavedPost::whereHas('post', function ($query) {
            $query->currentCountry();
        })->where('user_id', $currentUser->id)
            ->count();


        $query = User::with('profile')->where('user_type_id', 2);


        if (isset($params['gender_id']) && $params['gender_id'] != '') {
            $query->where('gender_id', $params['gender_id']);
        }
        if (isset($params['exp']) && $params['exp'] != '') {
            $query->whereHas('profile', function ($query) use ($params) {
                $query->where('experience_years', $params['exp']);
            });
        }

        /*if (isset($params['category_id']) && $params['category_id'] != null) {
            $query->where()
        }*/
        //dd($params['category_id']);
        if (isset($params['category_id']) && $params['category_id'] != null) {
            $query->whereHas('profile', function ($query) use ($params) {
                $query->where('expected_job_category_id', $params['category_id']);
            });
        }
        if (isset($params['position_id']) && $params['position_id'] != null) {
            $query->whereHas('profile', function ($query) use ($params) {
                $query->where('expected_job_position_id', $params['position_id']);
            });
        }

        if (isset($params['location']) && $params['location'] != null) {
            $query->whereHas('profile', function ($query) use ($params) {
                $query->where('expected_job_city_id', $params['location']);
            });
        }
        if (isset($params['expected_job_post_type_id']) && $params['expected_job_post_type_id'] != null) {
            $query->whereHas('profile', function ($query) use ($params) {
                $query->where('expected_job_post_type_id', $params['expected_job_post_type_id']);
            });
        }
        if (isset($params['experience_years']) && $params['experience_years'] != null) {
            $query->whereHas('profile', function ($query) use ($params) {
                $query->where('experience_years','>=',$params['experience_years']);
            });
        }
        $data['candidates'] = $query->orderBy('updated_at', 'DESC')->paginate(12);

        // Meta Tags
        MetaTag::set('title', t('Dashboard'));
        MetaTag::set('description', t('Dashboard - :app_name', ['app_name' => config('settings.app.app_name')]));


        return view('account.employer-search-index')->with($data);

    }

    public function doSearch()
    {
        $param = request()->all();

        $page = isset($param['page']) ? $param['page'] : 1;


        $candidates = User::where('user_type_id', 2)->orderBy('updated_at', 'DESC')->paginate(12);

        return response()->json([
            'success' => true
        ]);

    }

    public function viewProfile($hash)
    {
        $id = \Hashids::decode($hash)[0];
        //dd($id);
        $candidate = User::where('id', $id)->firstOrFail();
        //dd($candidate->profile->toArray());
        $currentUser = auth()->user();
        $profile = $candidate->profile;
        $profile->visits = $profile->visits + 1;
        $profile->save();


        $savedCheck = SavedCandidate::where('user_id', $currentUser->id)->where('candidate_id', $candidate->id)->count();

        $resume = Resume::where('user_id',$candidate->id)->first();
        activity('view_profile')->performedOn($candidate)
            ->causedBy($currentUser)
            ->withProperties(['action' => 'view_profile', 'name' => $candidate->name, 'id' => $candidate->id, 'hash' => $candidate->hash])
            ->log('Xem hồ sơ ứng viên <strong>:subject.name</strong> - mã hồ sơ <strong>'.$candidate->profile->getProfileCode().'</strong>');
        return view('account.inc.candidate-viewer', compact('candidate', 'profile', 'savedCheck','resume'));
    }

}
