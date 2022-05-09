<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\GeneralSetting\Services\UserNotificationSettingService;
use Modules\OrderManage\Entities\CustomerNotification;
use Modules\UserActivityLog\Traits\LogActivity;

use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{

    protected $userNotificationSettingService;

    public function __construct(UserNotificationSettingService $userNotificationSettingService)
    {
        $this->middleware(['auth', 'maintenance_mode']);
        $this->userNotificationSettingService = $userNotificationSettingService;
    }

    public function mark_as_read()
    {
        try {
            if (auth()->user()->role->type == "superadmin") {
                CustomerNotification::where('super_admin_read_status', 0)->update(['super_admin_read_status' => 1]);
            } else {
                CustomerNotification::where('seller_id', auth()->id())->update(['read_status' => 1]);
                CustomerNotification::where('customer_id', auth()->id())->update(['read_status' => 1]);
            }
            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }

    public function notifications()
    {
        try {
            if (auth()->user()->role->type == "superadmin" || auth()->user()->role->type == "admin" || auth()->user()->role->type == "staff" || auth()->user()->role->type == "seller") {
                return view('backEnd.pages.customer_data.all_notification');
            } else {
                $notifications = CustomerNotification::Where('customer_id', Auth::id())->latest()->limit(10)->get();

                return view('frontend.default.pages.profile.notifications', compact('notifications'));
            }
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }

    public function notificationsData()
    {
        if (auth()->user()->role->type == "superadmin" || auth()->user()->role->type == "admin") {
            $data = CustomerNotification::whereNotNull('seller_id')
                ->orWhere('customer_id', Auth::id())->latest();
        } elseif (auth()->user()->role->type == "seller") {
            $data = CustomerNotification::where('seller_id', Auth::id())
                ->orWhere('customer_id', Auth::id())->latest();
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('title', function ($data) {
                return $data->title;
            })
            ->addColumn('date', function ($data) {
                return date(app('general_setting')->dateFormat->format, strtotime($data->created_at));
            })
            ->addColumn('action', function ($data) {
                if ($data->url != '#') {
                    return ' <a href="' . $data->url . '"
                    class="primary-btn fix-gr-bg" id="save_button_parent"></i>' . __('common.view') . '</a>';
                }
            })
            ->toJson();
    }

    public function notification_setting()
    {
        try {
            if (auth()->user()->role->type == "customer") {
                $userNotificationSettings = $this->userNotificationSettingService->getByAuthUser(auth()->user()->id);
                return view('frontend.default.pages.profile.notification_setting', compact('userNotificationSettings'));
            } else {
                return redirect()->route('user.notificationsetting.index');
            }
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }

    public function notification_setting_update(Request $request, $id)
    {
        try {
            $this->userNotificationSettingService->update($request, $id);
            LogActivity::successLog('User notification updated successful.');
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }
}
