<?php

namespace Modules\Marketing\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Marketing\Services\ReferralCodeService;
use Exception;
use Modules\UserActivityLog\Traits\LogActivity;
use Yajra\DataTables\Facades\DataTables;

class ReferralCodeController extends Controller
{
    protected $referralCodeService;
    public function __construct(ReferralCodeService $referralCodeService)
    {
        $this->middleware('maintenance_mode');
        $this->referralCodeService = $referralCodeService;
    }
    
    public function index()
    {
        try{
            $setup = $this->referralCodeService->getSetup();
            return view('marketing::referral_code.index',compact('setup'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function getData(){
        $code = $this->referralCodeService->getAll();

        return DataTables::of($code)
            ->addIndexColumn()
            ->addColumn('name', function($code){
                return $code->user->first_name .' '. $code->user->last_name;
            })
            ->addColumn('date', function($code){
                return date(app('general_setting')->dateFormat->format, strtotime($code->created_at));
            })
            
            ->addColumn('status', function($code){
                return view('marketing::referral_code.components._status_td',compact('code'));
            })
            ->rawColumns(['status'])
            ->toJson();
    }

    public function updateSetup(Request $request){
        $request->validate([
            'amount' => 'required',
            'maximum_limit' => 'required',
            'status' =>'required'
        ]);

        try{
            $result = $this->referralCodeService->updateSetup($request->except('_token'));
            LogActivity::successLog('Referral Updated Successfully.');
            return $result;
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }
    public function statusChange(Request $request){
        try{
            $result = $this->referralCodeService->statusChange($request->except('_token'));
            LogActivity::successLog('Referral code Status Change Successfully.');
            return $result;
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }

    
}
