<?php

namespace Modules\GeneralSetting\Http\Controllers\Api;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use \Modules\GeneralSetting\Services\NotificationSettingService;
use Modules\GeneralSetting\Services\UserNotificationSettingService;
use Modules\OrderManage\Entities\CustomerNotification;
use Modules\UserActivityLog\Traits\LogActivity;

class NotificationController extends Controller
{

    protected $notificationSettingService;
    protected $customerNotificationSettingService;

    public function __construct(NotificationSettingService $notificationSettingService, UserNotificationSettingService $customerNotificationSettingService)
    {
        $this->notificationSettingService = $notificationSettingService;
        $this->customerNotificationSettingService = $customerNotificationSettingService;
    }


    // Notification Lists

    public function userNotifications(Request $request)
    {

        $user_id = $request->user()->id;
        $notifications = $this->notificationSettingService->userNotifications($user_id);

        if($notifications){
            return response()->json([
                'notifications' => $notifications
            ],200);
        }else{
            return response()->json([
                'message' => 'not found'
            ],404);
        }

    }
    // Notification setting

    public function notificationSetting(Request $request){
        $userNotificationSettings = $this->customerNotificationSettingService->getByAuthUser($request->user()->id);
        return response()->json([
            'notifications' => $userNotificationSettings,
            'msg' => 'success'
        ]);
    }

    // Setting Update

    public function notificationSettingUpdate(Request $request){
        $request->validate([
            'id' => 'required',
            'type' => 'required'
        ]);
        $this->customerNotificationSettingService->updateSettingForAPI($request);
        return response()->json([
            'msg' => 'updated successfully'
        ],202);
    }

    // Mark As read

    public function ReadALLNotifications(Request $request){
        try{
            CustomerNotification::where('customer_id', $request->user()->id)->update(['read_status' => 1]);
            return response()->json([
                'msg' => 'success'
            ],201);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }

}
