<?php

namespace Modules\GeneralSetting\Repositories;

use Modules\GeneralSetting\Entities\UserNotificationSetting;

class UserNotificationSettingRepository
{
    public function getByAuthUser($user_id=null)
    {
        return UserNotificationSetting::where('user_id', $user_id)->with('notification_setting')->get();
    }



    public function update($request, $id)
    {
        $notificationSetting = UserNotificationSetting::findOrFail($id);
        $notificationSetting->user_id = auth()->id();

        if (is_array($request->type)) {
            $notificationtype = "";
            if ($request->type) {
                foreach ($request->type as $type) {
                    $notificationtype .= $type . ",";
                }
            }
            $notificationSetting->type = $notificationtype;
        } else {

            $notificationSetting->type = $request->type;
        }


        $notificationSetting->save();
    }

    public function updateSettingForAPI($request){
        $notificationSetting = UserNotificationSetting::find($request->id);
        $notificationSetting->user_id = $request->user()->id;

        if (is_array($request->type)) {
            $notificationtype = "";
            if ($request->type) {
                foreach ($request->type as $type) {
                    $notificationtype .= $type . ",";
                }
            }
            $notificationSetting->type = $notificationtype;
        } else {

            $notificationSetting->type = $request->type;
        }

        $notificationSetting->save();
        return 1;
    }
}
