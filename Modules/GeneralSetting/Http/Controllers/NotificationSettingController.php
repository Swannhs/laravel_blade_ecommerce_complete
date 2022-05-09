<?php

namespace Modules\GeneralSetting\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use \Modules\GeneralSetting\Services\NotificationSettingService;
use Modules\UserActivityLog\Traits\LogActivity;

class NotificationSettingController extends Controller
{

    protected $notificationSettingService;

    public function __construct(NotificationSettingService $notificationSettingService)
    {
        $this->middleware('maintenance_mode');
        $this->notificationSettingService = $notificationSettingService;
    }


    public function index()
    {
        try {
            $notificationSettings = $this->notificationSettingService->all();
            return view('generalsetting::notifications.index', compact('notificationSettings'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }


    public function edit($id)
    {
        try {
            $notificationSetting = $this->notificationSettingService->single($id);
            return view('generalsetting::notifications.edit', compact('notificationSetting'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }


    public function update(Request $request, $id)
    {

        try {
            $request->validate([
                'message' => 'required',
            ]);
            $this->notificationSettingService->update($request, $id);
            Toastr::success(__('common.updated_successfully'),__('common.success'));
            LogActivity::successLog('notification updated successful.');
            return redirect()->route('notificationsetting.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }
}
