<?php

namespace Modules\GeneralSetting\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserNotificationSetting extends Model
{
    protected $guarded = [];

    public function notification_setting()
    {
        return $this->belongsTo(NotificationSetting::class);
    }

    public function createForRegisterUser($userId)
    {
        $notificationSettings =(new NotificationSetting())->getNotificationSettingByUserRoleType($userId);

        foreach($notificationSettings as $notificationSetting){
            UserNotificationSetting::create([
                'user_id' => $userId,
                'notification_setting_id' => $notificationSetting->id,
                'type' => $notificationSetting->type,
            ]);
        }
    }
}
