<?php


namespace App\Http\Controllers\Search;

use App\Helpers\Search;
use App\Models\Candidate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Torann\LaravelMetaTags\Facades\MetaTag;

class CandidateController extends BaseController
{
    private $perPage = 10;
    public $isCandidateSearch = true;
    public $candidate;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->perPage = (is_numeric(config('settings.listing.items_per_page'))) ? config('settings.listing.items_per_page') : $this->perPage;
    }

    /**
     * Listing of Candidate
     *
     * @return $this
     */
    public function index()
    {
        // Get Candidate List
        $candidates = User::with('profile')
            ->where('user_type_id', 2);
            //->join('user_profiles', 'users.id', '=', 'user_profiles.user_id');

        // Apply search filter
        if (Input::filled('q')) {
            $keywords = rawurldecode(Input::get('q'));
            $candidates = $candidates->where('users.name', 'LIKE', '%' . $keywords . '%')->whereOr('description', 'LIKE', '%' . $keywords . '%')
               ->orWhereHas('profile', function ($candidates) use ($keywords) {
                    $candidates->where('user_profiles.expected_job_title', 'LIKE', '%' . $keywords . '%');
            });
        }

        if (Input::filled('c')) {
            $catId = Input::get('c');
            $candidates = $candidates->whereHas('profile', function ($candidates) use ($catId) {
                    $candidates->where('user_profiles.expected_job_category_id', $catId);
                });
        }
        if (Input::filled('l')) {
            $locId = Input::get('l');
            $candidates = $candidates->whereHas('profile', function ($candidates) use ($locId) {
                $candidates->where('user_profiles.expected_job_city_id', $locId);
            });
        }
        // Get Candidate List with pagination
        $candidates = $candidates->orderBy('users.updated_at', 'desc')->orderBy('users.id', 'desc')->paginate($this->perPage);

        // Meta Tags
        MetaTag::set('title', t('Candidate List'));
        MetaTag::set('description', t('Candidate List - :app_name', ['app_name' => config('settings.app.app_name')]));

        return view('search.candidate.index')->with('candidates', $candidates);
    }

    /**
     * Show a Candidate profiles (with its Jobs ads)
     *
     * @param $countryCode
     * @param null $candidateId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile($hash)
    {
        $hash = \Hashids::decode($hash);

        $this->candidate = User::where('id', $hash[0])->firstOrFail();

        $data['relatedCandidates'] = User::whereHas('profile')
            //->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            //->where('user_profiles.expected_job_category_id', optional($this->candidate->profile)->expected_job_category_id)
            ->limit(5)->get();
        // Share the Candidate's info with the view
        $data['candidate'] = $this->candidate;

        if(!$this->candidate->profile){
            return redirect()->to('ung-vien')->with('error','Hồ sơ ứng viên không tồn tại hoặc đã bị khóa');
        }

        return view('search.candidate.profile', $data);
    }


    public function downloadPdf($hash)
    {

        if(!auth()->check()){
            return redirect()->to('login');
        }
        $hash = \Hashids::decode($hash);

        $candidate = User::where('id', $hash[0])->firstOrFail();
        //return view('search.candidate.profile-pdf', compact('candidate'));
        $pdf = \PDF::loadView('search.candidate.profile-pdf', compact('candidate'));
        return $pdf->download(str_slug($candidate->name) . '.pdf');

    }
}
