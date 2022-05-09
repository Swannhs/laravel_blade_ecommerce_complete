<?php

namespace Modules\GeneralSetting\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GeneralSetting\Entities\UserNotificationSetting;
use \Modules\GeneralSetting\Services\UserNotificationSettingService;
use Modules\UserActivityLog\Traits\LogActivity;

class UserNotificationSettingController extends Controller
{

    protected $userNotificationSettingService;

    public function __construct(UserNotificationSettingService $userNotificationSettingService)
    {
        $this->middleware('maintenance_mode');
        $this->userNotificationSettingService = $userNotificationSettingService;
    }


    public function index()
    {

        try {
             $userNotificationSettings = $this->userNotificationSettingService->getByAuthUser(auth()->id());
            return view('generalsetting::user_notifications.index', compact('userNotificationSettings'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }



    public function update(Request $request, $id)
    {


        try {
            $this->userNotificationSettingService->update($request, $id);
            LogActivity::successLog('User notification updated successful.');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }
}
