<?php
namespace Modules\GeneralSetting\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\GeneralSetting\Repositories\UserNotificationSettingRepository;
use Illuminate\Support\Arr;

class UserNotificationSettingService
{
    protected $userNotificationSettingRepository;

    public function __construct(UserNotificationSettingRepository  $userNotificationSettingRepository)
    {
        $this->userNotificationSettingRepository = $userNotificationSettingRepository;
    }

    public function getByAuthUser($user_id=null)
    {
        return $this->userNotificationSettingRepository->getByAuthUser($user_id);
    }

    public function update($request,$id)
    {
        return $this->userNotificationSettingRepository->update($request,$id);
    }

    public function updateSettingForAPI($request){
        return $this->userNotificationSettingRepository->updateSettingForAPI($request);
    }
}
