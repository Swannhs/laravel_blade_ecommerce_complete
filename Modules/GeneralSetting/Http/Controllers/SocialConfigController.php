<?php

namespace Modules\GeneralSetting\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GeneralSetting\Repositories\SocialConfigRepository;
use Modules\UserActivityLog\Traits\LogActivity;

class SocialConfigController extends Controller
{
    protected $socialConfigRepository;
    public function __construct(SocialConfigRepository $socialConfigRepository){
        $this->middleware('maintenance_mode');
        $this->socialConfigRepository = $socialConfigRepository;
    }

    public function social_login_configuration()
    {
        try {
            $messanger_chat = $this->socialConfigRepository->getMessangerData();
            return view('generalsetting::social_login_configuration',compact('messanger_chat'));
        } catch (\Exception $e) {
            Toastr::error(__('common.operation_failed'));
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }

    public function social_login_configuration_update(Request $request)
    {
        try {
            $this->socialConfigRepository->socialLoginConfigurationUpdate($request);
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('track order configuration updated.');
            return back();
        } catch (\Exception $e) {
            Toastr::error(__('common.operation_failed'));
            LogActivity::errorLog($e->getMessage());
            return back();
        }

    }

    public function messangerChatUpdate(Request $request){

        $this->socialConfigRepository->messangerChatUpdate($request->except('_token'));
            LogActivity::successLog('MessangerChat code Update');
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            return redirect()->back();
        try{
            $this->socialConfigRepository->messangerChatUpdate($request->except('_token'));
            LogActivity::successLog('MessangerChat code Update');
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            return redirect()->back();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'), __('common.error'));
            return redirect()->back();
        }

    }
    
}
