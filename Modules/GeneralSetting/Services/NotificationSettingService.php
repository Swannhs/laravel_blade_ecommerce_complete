<?php
namespace Modules\GeneralSetting\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\GeneralSetting\Repositories\NotificationSettingRepository;
use Illuminate\Support\Arr;

class NotificationSettingService
{
    protected $notificationSettingRepository;

    public function __construct(NotificationSettingRepository  $notificationSettingRepository)
    {
        $this->notificationSettingRepository = $notificationSettingRepository;
    }

    public function all()
    {
        return $this->notificationSettingRepository->all();
    }

    public function single($id)
    {
        return $this->notificationSettingRepository->single($id);
    }

    public function update($request,$id)
    {
        return $this->notificationSettingRepository->update($request,$id);
    }


    public function userNotifications($user_id)
    {
        return $this->notificationSettingRepository->userNotifications($user_id);
    }
}
