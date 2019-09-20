<?php


namespace App\Http\Controllers\Ajax;

use App\Services\ChartBuilder;
use App\Models\PaidCandidate;
use App\Models\Post;
use App\Http\Controllers\FrontController;
use App\Models\SavedCandidate;
use App\Models\SavedPost;
use App\Models\SavedSearch;
use App\Models\Scopes\VerifiedScope;
use App\Models\Scopes\ReviewedScope;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Icetea\TextToImage\Facades\TextToImage;
use Spatie\Activitylog\Models\Activity;

class EmployerController extends FrontController
{
    /**
     * PostController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCandidate(Request $request)
    {
        $candidateId = $request->input('id');
        $candidate = User::where('id', $candidateId)->firstOrFail();
        $currentUser = auth()->user();
        $status = 0;
        if (auth()->check()) {
            $savedCandidate = SavedCandidate::where('user_id', $currentUser->id)->where('candidate_id', $candidateId);
            if ($savedCandidate->count() > 0) {
                // Delete SavedCandidate
                $savedCandidate->delete();
                $status = 1;
                $result = [
                    'logged' => (auth()->check()) ? auth()->user()->id : 0,
                    'candidateId' => $candidateId,
                    'status' => $status,
                    'msg' => 'Đã hủy lưu hồ sơ',
                    'action' => 'drop'
                ];
                activity('drop_profile')->performedOn($candidate)
                    ->causedBy($currentUser)
                    ->withProperties(['action' => 'drop_profile', 'name' => $candidate->name, 'id' => $candidate->id, 'hash' => $candidate->hash])
                    ->log('Bỏ lưu hồ sơ ứng viên <strong>:subject.name</strong> - mã hồ sơ <strong>'.$candidate->profile->getProfileCode().'</strong>');
                return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
            } else {
                // Store SavedCandidate
                $savedCandidateInfo = [
                    'user_id' => auth()->user()->id,
                    'candidate_id' => $candidateId,
                ];
                $savedCandidate = new SavedCandidate($savedCandidateInfo);
                $savedCandidate->save();
                $status = 1;

                $result = [
                    'logged' => (auth()->check()) ? auth()->user()->id : 0,
                    'candidateId' => $candidateId,
                    'status' => $status,
                    'msg' => 'Đã lưu hồ sơ',
                    'action' => 'save'
                ];
                activity('save_profile')->performedOn($candidate)
                    ->causedBy($currentUser)
                    ->withProperties(['action' => 'save_profile', 'name' => $candidate->name, 'id' => $candidate->id, 'hash' => $candidate->hash])
                    ->log('Lưu hồ sơ ứng viên <strong>:subject.name</strong> - mã hồ sơ <strong>'.$candidate->profile->getProfileCode().'</strong>');
                return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
            }
        }
        $result = [
            'logged' => (auth()->check()) ? auth()->user()->id : 0,
            'candidateId' => $candidateId,
            'status' => $status,
            'loginUrl' => url(config('lang.abbr') . '/' . trans('routes.login')),
        ];

        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function paidCandidate(Request $request)
    {
        $candidateId = $request->input('id');
        $currentUser = auth()->user();
        $status = 0;
        if (auth()->check()) {
            if ($currentUser->point <= 0 && ($currentUser->is_admin == 0)) {
                $result = [
                    'logged' => $currentUser->id,
                    'candidateId' => $candidateId,
                    'status' => 0,
                    'msg' => 'Bạn cần nạp thêm điểm vào tài khoản để xem được hồ sơ'
                ];
                return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
            }

            $paidCandidate = PaidCandidate::where('user_id', $currentUser->id)->where('candidate_id', $candidateId);
            if ($paidCandidate->count() > 0) {
                $status = 1;
                $result = [
                    'logged' => $currentUser ? $currentUser->id : 0,
                    'candidateId' => $candidateId,
                    'status' => $status,
                    'msg' => 'Đã được thanh toán điểm'
                ];

                return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
            } else {
                // Store PaidCandidate

                $candidate = User::with('profile')->where('id', $candidateId)->firstOrFail();


                if (($currentUser->point > 0 && ($currentUser->point - $candidate->profile->getPoint() >= 0)) || ($currentUser->is_admin == 1)) {
                    if ($currentUser->is_admin != 1) {
                        $currentUser->point = $currentUser->point - $candidate->profile->getPoint();
                        $currentUser->save();
                    }

                    $paidCandidateInfo = [
                        'user_id' => auth()->user()->id,
                        'candidate_id' => $candidateId,
                        'point' => optional($candidate->profile)->point
                    ];
                    $paidCandidate = new PaidCandidate($paidCandidateInfo);
                    $paidCandidate->save();

                    $result = [
                        'logged' => $currentUser->id,
                        'candidateId' => $candidateId,
                        'status' => 1,
                        'msg' => 'Đã thanh toán điểm',
                        'content' => '   <p><strong>Họ tên </strong>: ' . $candidate->name . ' </p>
                    <p><strong>Giới tính</strong>: ' . optional($candidate->gender)->name . '</p>
                    <p><strong>Số điện thoại</strong>: ' . $candidate->phone . '</p>
                    <p><strong>Email</strong>: ' . $candidate->email . '</p>
                    <p><strong>Địa chỉ</strong>: ' . $candidate->address . '</p>'
                    ];
                    activity('pay_profile')->performedOn($candidate)
                        ->causedBy($currentUser)
                        ->withProperties(['action' => 'pay_profile', 'name' => $candidate->name, 'id' => $candidate->id, 'hash' => $candidate->hash])
                        ->log('Thanh toán điểm hồ sơ ứng viên <strong>:subject.name</strong> - mã hồ sơ <strong>'.$candidate->profile->getProfileCode().'</strong>');

                } else {
                    $result = [
                        'logged' => $currentUser->id,
                        'candidateId' => $candidateId,
                        'status' => 0,
                        'msg' => 'Bạn cần nạp thêm điểm vào tài khoản để xem được hồ sơ'
                    ];

                }

                return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
            }
        }
        $result = [
            'logged' => $currentUser ? $currentUser->id : 0,
            'candidateId' => $candidateId,
            'status' => 0,
            'loginUrl' => url(config('lang.abbr') . '/' . trans('routes.login')),
        ];

        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSavedCandidate(Request $request)
    {
        $candidateId = $request->input('id');

        $status = 0;
        if (auth()->check()) {
            $savedCandidate = SavedCandidate::where('user_id', auth()->user()->id)->where('candidate_id', $candidateId);
            if ($savedCandidate->count() > 0) {
                // Delete SavedCandidate
                $savedCandidate->delete();
            }
        }

        $result = [
            'logged' => (auth()->check()) ? auth()->user()->id : 0,
            'candidateId' => $candidateId,
            'status' => $status,
            'msg' => 'Hồ sơ đã được hủy lưu lại'
        ];

        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function getViewChart()
    {
        $range = request()->get('range', '7days');
        $currentUser = auth()->user();

        switch ($range) {
            case '1month':
                $startDate = Carbon::today()->startOfMonth();
                $endDate = Carbon::today()->endOfMonth();
                $pstartDate = Carbon::today()->startOfMonth();
                $pendDate = Carbon::today()->endOfMonth();
                $labels = $this->generateDateRange(Carbon::today()->startOfMonth(), Carbon::today()->endOfMonth(), 'Y-m-d');
                break;
            case '3months':
                $startDate = Carbon::today()->subMonths(3)->startOfMonth();
                $endDate = Carbon::today()->endOfMonth();
                $pstartDate = Carbon::today()->subMonths(3)->startOfMonth();
                $pendDate = Carbon::today()->endOfMonth();
                $labels = $this->generateDateRange(Carbon::today()->subMonths(3)->startOfMonth(), Carbon::today()->endOfMonth(), 'Y-m-d');
                break;
            case '7days':
            default:
                $startDate = Carbon::today()->subDays(7);
                $endDate = Carbon::today();
                $pstartDate = Carbon::today()->subDays(7);
                $pendDate = Carbon::today();
                $labels = $this->generateDateRange(Carbon::today()->subDays(7), Carbon::today(), 'Y-m-d');
                break;
        }


        $viewProfileData = $this->getActivityStats($currentUser->id, 'view_profile',
            $startDate,
            $endDate);
        $viewPostData = $this->getActivityStats($currentUser->id, 'view_post',
            $pstartDate,
            $pendDate);

        $str = $this->makeChart($viewProfileData, $viewPostData)->render();
        return $str;
    }

    private function makeChart($profileData, $postData)
    {
        $chartjs = new ChartBuilder();
        return $chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 150])
            ->labels($profileData['labels'])
            ->datasets([
                [
                    "label" => "Lượt xem hồ sơ",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $profileData['stats'],
                ],
                [
                    "label" => "Lượt xem tin tuyển dụng",
                    'backgroundColor' => "#FFE0E6",
                    'borderColor' => "#FFE0C6",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $postData['stats'],
                ]
            ])->options([]);
    }

    private function getActivityStats($userId, $action, $startDate, $endDate)
    {


        $stats = Activity::where('causer_id', $userId)
            ->where('log_name', $action)
            ->where('created_at', '>=', $startDate->format('Y-m-d'))
            ->where('created_at', '<=', $endDate->format('Y-m-d'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get(array(
                \DB::raw('Date(created_at) as date'),
                \DB::raw('COUNT(*) as "views"')
            ))->pluck('views', 'date');

        $results = [];
        $labels = $this->generateDateRange($startDate, $endDate, 'Y-m-d');
        //dd($labels);
        foreach ($labels as $label) {
            $results[$label] = 0;
        }
        foreach ($stats as $key => $val) {
            $results[$key] = $val;
        }
        return [
            'labels' => $labels,
            'stats' => array_values($results)
        ];
    }


    private function generateDateRange(Carbon $start_date, Carbon $end_date, $format = 'd-m-Y')
    {
        $dates = [];

        $sDate = $start_date;
        $eDate = $end_date;

        for ($date = $sDate; $date->lte($eDate); $date->addDay()) {
            $dates[] = $date->format($format);
        }

        return $dates;
    }


}
