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
use App\Models\Scopes\VerifiedScope;
use App\Models\SkillType;
use App\Models\UserType;
use Carbon\Carbon;
use Composer\DependencyResolver\Transaction;
use Creativeorange\Gravatar\Facades\Gravatar;
use App\Models\Post;
use App\Models\SavedPost;
use App\Models\Gender;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Models\User;
use Illuminate\Http\Request as HttpRequest;

class DashboardController extends AccountBaseController
{
    private $perPage = 10;
    public $pagePath = 'dashboard';

    public function __construct()
    {
        parent::__construct();

        $this->perPage = (is_numeric(config('settings.listing.items_per_page'))) ? config('settings.listing.items_per_page') : $this->perPage;

        view()->share('pagePath', $this->pagePath);
    }

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
            return $this->employerDashboard();
        } else {
            return $this->candidateDashboard();
        }
    }


    private function employerDashboard()
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
        $data['cities'] = City::where('country_code', 'VN')->orderBy('name', 'asc')->get();
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

        $data['latestPosts'] = Post::currentCountry()
            ->where('user_id', $currentUser->id)
            ->limit(5)
            ->orderBy('id', 'desc')
            ->get();

        $data['latestViewedCandidates'] = User::with('profile')
            ->where('paid_candidates.user_id',$currentUser->id)
            ->join('paid_candidates', 'users.id', '=', 'paid_candidates.candidate_id')
            ->limit(5)
            ->get();

        $data['latestTransactions'] = $this->transactions->orderBy('id', 'desc')->limit(5)->get();

        // Meta Tags
        MetaTag::set('title', t('Dashboard'));
        MetaTag::set('description', t('Dashboard:app_name', ['app_name' => config('settings.app.app_name')]));

        return view('account.dashboard.employer-index', $data);
    }

    private function candidateDashboard()
    {

        // Meta Tags
        MetaTag::set('title', t('Dashboard'));
        MetaTag::set('description', t('Dashboard - :app_name', ['app_name' => config('settings.app.app_name')]));


        $currentUser = auth()->user();
        $profile = $currentUser->profile;
        $data['suitableJobs'] = [];

        if (isset($profile->expected_job_category_id) && $profile->expected_job_category_id != null) {
            $data['suitableJobs'] = Post::where('category_id', $profile->expected_job_category_id)->orderBy('featured', 'desc')->orderBy('updated_at', 'desc')->limit(12)->get();
        }

        //$data['suitableJobs'] = Post::orderBy('featured', 'desc')->orderBy('updated_at', 'desc')->limit(12)->get();
        $data['savedJobs'] = Post::select(['posts.*'])->join('saved_posts', 'saved_posts.post_id', '=', 'posts.id')
            ->where('saved_posts.user_id', $currentUser->id)
            ->orderBy('featured', 'desc')->orderBy('posts.updated_at', 'desc')->limit(12)->get();

        $data['appliedJobs'] = Activity::where('log_name', 'apply_job')->where('causer_id', $currentUser->id)
            ->where('subject_type', 'App\Models\Post')
            ->orderBy('id', 'desc')->limit(12)->get();
        return view('account.dashboard.candidate-index', $data);
    }


    /**
     * @param HttpRequest $request
     * @return View
     */
    public function getSavedCandidates(HttpRequest $request)
    {
        $data = [];

        $candidates = User::where('user_type_id', 2)
            ->join('saved_candidates', 'saved_candidates.candidate_id', '=', 'users.id')
            //->groupBy('saved_candidates.candidate_id')
            ->where('saved_candidates.user_id', '=', auth()->user()->id)
            ->orderBy('saved_candidates.id', 'desc')
            ->paginate(12);

        $data['candidates'] = $candidates;

        // Meta Tags
        MetaTag::set('title', t('My saved candidate'));
        MetaTag::set('description', t('My saved candidate on :app_name', ['app_name' => config('settings.app.app_name')]));

        view()->share('pagePath', 'saved-candidates');

        return view('account.saved-candidates', $data);
    }

    /**
     * @param HttpRequest $request
     * @return View
     */
    public function getPaidCandidates()
    {
        $data = [];
        $candidates = User::where('user_type_id', 2)
            ->join('paid_candidates', 'paid_candidates.candidate_id', '=', 'users.id')
            //->groupBy('saved_candidates.candidate_id')
            ->where('paid_candidates.user_id', '=', auth()->user()->id)
            ->orderBy('paid_candidates.id', 'desc')
            ->paginate(12);

        $data['candidates'] = $candidates;

        // Meta Tags
        MetaTag::set('title', 'Hồ sơ đã xem');
        MetaTag::set('description', t('My saved candidate on :app_name', ['app_name' => config('settings.app.app_name')]));

        view()->share('pagePath', 'viewed-candidates');

        return view('account.viewed-candidates', $data);
    }
}
