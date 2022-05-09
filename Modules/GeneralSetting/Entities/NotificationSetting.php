<?php

namespace Modules\GeneralSetting\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $guarded = [];


    public function getNotificationSettingByUserRoleType($userId)
    {
        $user = User::find($userId);
        $notificationSettings="";
        if($user->role->type == "customer"){
            $notificationSettings = NotificationSetting::where('user_access_status',1)->get();
        }elseif($user->role->type == "seller"){
            $notificationSettings = NotificationSetting::where('seller_access_status',1)->get();
        }elseif($user->role->type == "staff"){
            $notificationSettings = NotificationSetting::where('staff_access_status',1)->get();
        }elseif($user->role->type == "superadmin" || $user->role->type == "admin"){
            $notificationSettings = NotificationSetting::where('admin_access_status',1)->orWhere('seller_access_status',1)->get();
        }

        return $notificationSettings;

    }
}
