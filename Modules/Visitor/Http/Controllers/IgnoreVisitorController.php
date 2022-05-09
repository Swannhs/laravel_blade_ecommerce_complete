<?php

namespace Modules\Visitor\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Modules\UserActivityLog\Traits\LogActivity;
use Modules\Visitor\Entities\IgnoreIP;
use Yajra\DataTables\Facades\DataTables;

class IgnoreVisitorController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }

    public function index()
    {
        return view('visitor::ignore_ip.index');
    }

    public function getIPList(){
        $ip = IgnoreIP::latest();
        return DataTables::of($ip)
        ->addIndexColumn()
        ->addColumn('action', function($ip){
            return view('visitor::ignore_ip.components._td_action', compact('ip'));
        })
        ->toJson();
    }


    public function store(Request $request)
    {
        $request->validate([
            'ip' => 'required|unique:ignore_ip|max:255',
        ]);
        try {
            IgnoreIP::create([
                'ip' => $request->ip
            ]);
            LogActivity::successLog('IP added into ignore List.');
            return response()->json([
                "message" => "IP Added into ignore List Successfully",
                "ip_list" => (string)view('visitor::ignore_ip.list')

            ], 200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => $e->getMessage(), "error" => $e->getMessage()], 503);
        }
    }


    public function destroy($id)
    {
        try {
            IgnoreIP::findOrFail($id)->delete();
            Toastr::success(__('common.deleted_successfully'), __('common.success'));
            LogActivity::successLog('IP delete from  ignore list.');
            return redirect()->route('ignore_ip_list');
        } catch (\Exception $e) {
            Toastr::error(__('common.error_message'), __('common.error'));
            \LogActivity::errorLog($e->getMessage());
            return back();
        }

    }
}
