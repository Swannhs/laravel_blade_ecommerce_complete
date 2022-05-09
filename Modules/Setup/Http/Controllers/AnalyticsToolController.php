<?php

namespace Modules\Setup\Http\Controllers;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setup\Services\AnalyticsService;
use Brian2694\Toastr\Facades\Toastr;
use Modules\UserActivityLog\Traits\LogActivity;

class AnalyticsToolController extends Controller
{

    protected $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->middleware('maintenance_mode');
        $this->analyticsService = $analyticsService;
    }


    public function index()
    {
        try{
            $analytics = $this->analyticsService->getAnalytics();
            $businessData = $this->analyticsService->getBusinessData();

            return view('setup::analytics.index', compact('analytics', 'businessData'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

    public function googleAnalyticsUpdate(Request $request){

        $request->validate([
            'ANALYTICS_TRACKING_ID' => 'required',
            'MEASUREMENT_ID' => 'nullable',
            'MEASUREMENT_PROTOCOL_API_SECRET' => 'nullable',
            'ANALYTICS_VIEW_ID' => ($request->ANATYTIC_RESULT_DASHBOARD == 1)?'required':'nullable'

        ]);

        try{
            $this->analyticsService->googleAnalyticsUpdate($request->except('_token'));
            LogActivity::successLog('google analytics tool updated successfully');
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            return back();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function facebookPixelUpdate(Request $request){

        try{
            $this->analyticsService->facebookPixelUpdate($request->except('_token'));
            LogActivity::successLog('facebook pixel updated successfully');
            return true;
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e
            ],503);
        }
    }

}
