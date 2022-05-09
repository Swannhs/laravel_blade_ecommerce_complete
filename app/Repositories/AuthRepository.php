<?php
namespace App\Repositories;

use App\Models\User;
use App\Traits\Notification;
use Illuminate\Support\Facades\Hash;
use Modules\GeneralSetting\Entities\EmailTemplateType;
use Modules\GeneralSetting\Entities\UserNotificationSetting;
use Modules\Marketing\Entities\ReferralCodeSetup;
use Modules\Marketing\Entities\ReferralUse;
use Modules\Marketing\Entities\ReferralCode;

class AuthRepository{

    use Notification;

    public function register($data){

        $field = $data['email'];
        if (is_numeric($field)) {
            $phone=$data['email'];
        }
        elseif (filter_var($field, FILTER_VALIDATE_EMAIL)) {
            $email=$data['email'];
        }

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => isset($data['last_name'])?$data['last_name']:null,
            'username' => isset($phone)?$phone:NULL,
            'email' => isset($email)?$email:NULL,
            'password' => Hash::make($data['password']),
            'role_id' => 4,
            'phone' => isset($phone)?$phone:NULL,
        ]);

        // User Notification Setting Create
        (new UserNotificationSetting())->createForRegisterUser($user->id);
        $this->typeId = EmailTemplateType::where('type','register_email_template')->first()->id;//register email templete typeid
        $this->notificationSend("Register",$user->id);

        if(isset($data['referral_code'])){
            $referralData = ReferralCodeSetup::first();
            $referralExist = ReferralCode::where('referral_code', $data['referral_code'])->first();
            if ($referralExist) {
                $referralExist->update(['total_used' => $referralExist->total_used + 1]);
                ReferralUse::create([
                    'user_id' => $user->id,
                    'referral_code' => $data['referral_code'],
                    'discount_amount' => $referralData->amount
                ]);
            }
        }
        return $user;
    }

    public function changePassword($user, $data){

        if($user && Hash::check($data['old_password'], $user->password)){

            User::where('id', $user['id'])->update([
                'password' => Hash::make($data['password'])
            ]);
            return true;

        }else{
            return false;
        }

    }

}
