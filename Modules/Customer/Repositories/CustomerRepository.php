<?php

namespace Modules\Customer\Repositories;

use App\Models\Order;
use Modules\Customer\Entities\CustomerAddress;
use App\Models\User;
use App\Traits\Notification;
use App\Traits\SendMail;
use Illuminate\Support\Facades\Hash;
use Modules\GeneralSetting\Entities\EmailTemplateType;
use Modules\GeneralSetting\Entities\UserNotificationSetting;
use Modules\Marketing\Entities\ReferralCode;
use Modules\Marketing\Entities\ReferralCodeSetup;
use Modules\Marketing\Entities\ReferralUse;
use Modules\OrderManage\Entities\CustomerNotification;
use Modules\Setup\Entities\Country;
use Modules\Setup\Entities\State;
use Modules\Wallet\Entities\WalletBalance;

class CustomerRepository
{
    use Notification, SendMail;
    public function getAll()
    {
        return User::with('wallet_balances', 'orders')->where('role_id', 4);
    }

    public function find($id)
    {
        return User::with('wallet_balances', 'orders', 'customerAddresses')->findOrFail($id);
    }

    public function store($data){
        $field = $data['email'];
        if (is_numeric($field)) {
            $phone = $data['email'];
        } elseif (filter_var($field, FILTER_VALIDATE_EMAIL)) {
            $email = $data['email'];
        }
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => isset($phone) ? $phone : NULL,
            'email' => isset($email) ? $email : NULL,
            'verify_code' => sha1(time()),
            'password' => Hash::make($data['password']),
            'role_id' => 4,
            'phone' => isset($phone) ? $phone : NULL,
            'is_verified' => 1,
            'is_active' => $data['status']
        ]);

        // User Notification Setting Create
        (new UserNotificationSetting)->createForRegisterUser($user->id);
        $this->typeId = EmailTemplateType::where('type', 'register_email_template')->first()->id; //register email templete typeid
        $this->notificationSend("Register", $user->id);

        if (isset($data['referral_code'])) {
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

    public function update($data, $id){
        $field = $data['email'];
        if (is_numeric($field)) {
            $phone = $data['email'];
        } elseif (filter_var($field, FILTER_VALIDATE_EMAIL)) {
            $email = $data['email'];
        }
        $user = User::find($id);
        $user->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => isset($phone) ? $phone : NULL,
            'email' => isset($email) ? $email : NULL,
            'password' => ($data['password'] != null)?Hash::make($data['password']):$user->password,
            'is_active' => $data['status']
        ]);
        return $user;

    }

    public function destroy($id){
        $customer = User::find($id);
        $customer_orders  = Order::where('customer_id',$id)->pluck('id');
        $wallet = WalletBalance::where('user_id', $id)->pluck('id');
        if($customer_orders->count() || $wallet->count()){
            return false;
        }
        $addresses = $customer->customerAddresses->pluck('id');
        CustomerAddress::destroy($addresses);
        $notifications = CustomerNotification::where('customer_id', $id)->pluck('id');
        CustomerNotification::destroy($notifications);
        $notification_settings = UserNotificationSetting::where('user_id', $id)->pluck('id');
        UserNotificationSetting::destroy($notification_settings);
        $customer->delete();
        return true;
    }

}
