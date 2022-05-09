<?php

namespace Modules\OrderManage\Repositories;

use App\Models\User;
use Modules\OrderManage\Entities\DeliveryProcess;
use Carbon\Carbon;
use Modules\GeneralSetting\Entities\NotificationSetting;
use Modules\GeneralSetting\Entities\UserNotificationSetting;

class DeliveryProcessRepository
{
    public function getAll()
    {
        return DeliveryProcess::all();
    }

    public function save($data)
    {
        $deliveryProcess = DeliveryProcess::create([
            'name' => $data['name'],
            'description' => $data['description']
        ]);

        $notificationSetting = NotificationSetting::create([
            'event' => $deliveryProcess->name,
            'delivery_process_id' => $deliveryProcess->id,
            'type' => 'system',
            'message' => $deliveryProcess->name,
            'user_access_status' => 0
        ]);
        $users = User::all();
        foreach ($users as $user) {
            UserNotificationSetting::create([
                'user_id' => $user->id,
                'notification_setting_id' => $notificationSetting->id,
                'type' => 'system'

            ]);
        }
    }

    public function update($data, $id)
    {
        $deliveryProcess = DeliveryProcess::findOrFail($id);
        $deliveryProcess->update([
            'name' => $data['name'],
            'description' => $data['description']
        ]);
        NotificationSetting::where('delivery_process_id',$deliveryProcess->id)->update([
            'event' => $data['name'],
        ]);
    }

    public function delete($id)
    {
        return DeliveryProcess::findOrFail($id)->delete();
    }
}
