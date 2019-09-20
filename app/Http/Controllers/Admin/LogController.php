<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Icetea\Admin\app\Http\Controllers\Controller;
use Prologue\Alerts\Facades\Alert;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    /**
     * ActionController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        $type = request()->get('type', '');
        $keyword = request()->get('keyword', '');
        $user = request()->get('user', '');
        $query = Activity::orderBy('id', 'desc');
        if ($type) {
            $query->where('log_name', $type);
        }
        if ($keyword) {
            $query->where('description', 'LIKE', '%' . $keyword . '%');
        }
        if ($user) {
            $query->whereHas('causer', function ($query) use ($user) {
                $query->where('name', 'LIKE', '%' . $user . '%');
            });
        }
        $activities = $query->paginate(20);
        //dd($activities->toArray());
        return view('vendor.admin.logs', compact('activities'));
    }
}
