<?php

namespace Modules\UserActivityLog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Modules\UserActivityLog\Traits\LogActivity;
use Yajra\DataTables\Facades\DataTables;

class UserActivityLogController extends Controller
{

    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }

    public function index()
    {
        try{
            return view('useractivitylog::index');
        }catch(\Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'));
            return redirect()->back();
        }
    }

    public function getLogActivityData(){
        $activity = LogActivity::logActivityLists();
        return DataTables::of($activity)
        ->addIndexColumn()
        ->addColumn('user_name', function($activity){
            return $activity->user->first_name;
        })
        ->addColumn('type', function($activity){
            return view('useractivitylog::components._type_td',compact('activity'));
        })
        ->addColumn('attempt_at', function($activity){
            return date("h:i:s a Y-m-d", strtotime($activity->updated_at));
        })
        ->rawColumns(['type'])
        ->toJson();
    }

    public function login_index()
    {
        try{
            $activities = LogActivity::logActivityListsDuty();
            return view('useractivitylog::login_index', compact('activities'));
        }catch(\Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'));
            return redirect()->back();
        }
    }

    public function getLoginLogoutData(){
        $activity = LogActivity::logActivityListsDuty();

        return DataTables::of($activity)
        ->addIndexColumn()
        ->addColumn('user_name', function($activity){
            return $activity->user->first_name;
        })
        ->addColumn('login_time', function($activity){
            return date("h:i:s a Y-m-d", strtotime($activity->login_time));
        })
        ->addColumn('logout_time', function($activity){
            return date("h:i:s a Y-m-d", strtotime($activity->logout_time));
        })
        ->toJson();
    }

    public function log_activity_destroy_all(Request $request){
        LogActivity::log_activity_destroy_all();
        return $this->reloadWithLogData();
    }

    public function login_activity_destroy_all(Request $request){
        LogActivity::login_activity_destroy_all();
        return $this->reloadWithLogData();
    }

    private function reloadWithLogData(){
        return response()->json([
            'log_lists' => (string)view('useractivitylog::components.log_list'),
            'login_lists' => (string)view('useractivitylog::components.login_list')
        ]);
    }

}
