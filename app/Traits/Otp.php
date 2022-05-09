<?php

namespace App\Traits;

use Illuminate\Support\Facades\Session;
use Modules\GeneralSetting\Entities\SmsTemplate;
use Modules\Otp\Entities\Otp as EntitiesOtp;
use Str;

trait Otp
{
    use SendMail, SendSMS;

    public function sendOtp($request, $type = Null)
    {
        $code = random_int(100000, 999999);

        $minutes = time() + (otp_configuration('code_validation_time') * 60);
        $validation_time = date('Y-m-d H:i:s', $minutes);

        if ($type == "resend") {
            Session::forget('otp');
            Session::forget('validation_time');
        }

        Session::put('otp', $code);
        Session::put('validation_time', $validation_time);
        Session::forget('code_validation_time');

        if (is_numeric($request->email)) {
            $smsTemplete = SmsTemplate::where('type_id', 35)->where('is_active', 1)->first(); //registration templete
            $msg = $smsTemplete->value . $code;
            return $this->sendSMS($request->email, $msg);
        } elseif (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return $this->sendOtpByMail($request, $code);
        }
    }

    public function sendLoginOtp($request, $type = Null)
    {
        $code = random_int(100000, 999999);

        $minutes = time() + (otp_configuration('code_validation_time') * 60);
        $validation_time = date('Y-m-d H:i:s', $minutes);

        if ($type == "resend") {
            Session::forget('otp');
            Session::forget('validation_time');
        }

        Session::put('otp', $code);
        Session::put('validation_time', $validation_time);
        Session::forget('code_validation_time');

        if (is_numeric($request->email)) {
            $smsTemplete = SmsTemplate::where('type_id', 37)->where('is_active', 1)->first(); //registration templete
            $msg = $smsTemplete->value . $code;
            return $this->sendSMS($request->email, $msg);
        } elseif (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return $this->sendLoginOtpByMail($request, $code);
        }
    }

    public function sendPasswordResetOtp($request, $type = Null)
    {
        $code = random_int(100000, 999999);

        $minutes = time() + (otp_configuration('code_validation_time') * 60);
        $validation_time = date('Y-m-d H:i:s', $minutes);

        if ($type == "resend") {
            Session::forget('otp');
            Session::forget('validation_time');
        }

        Session::put('otp', $code);
        Session::put('validation_time', $validation_time);
        Session::forget('code_validation_time');

        if (is_numeric($request->email)) {
            $smsTemplete = SmsTemplate::where('type_id', 38)->where('is_active', 1)->first(); //registration templete
            $msg = $smsTemplete->value . $code;
            return $this->sendSMS($request->email, $msg);
        } elseif (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return $this->sendPasswordResetOtpByMail($request, $code);
        }
        return redirect()->back();
    }
    

    public function sendOtpForSeller($request, $type = Null)
    {
        $code = random_int(100000, 999999);

        $minutes = time() + (otp_configuration('code_validation_time') * 60);
        $validation_time = date('Y-m-d H:i:s', $minutes);

        if ($type == "resend") {
            Session::forget('otp');
            Session::forget('validation_time');
        }

        Session::put('otp', $code);
        Session::put('validation_time', $validation_time);
        Session::forget('code_validation_time');

        $emailSend = false;
        $smsSend = false;

        if (Str::contains(otp_configuration('otp_type_registration'), 'email')) {
            $emailSend = $this->sendOtpByMailForSeller($request, $code);
        }
        if (Str::contains(otp_configuration('otp_type_registration'), 'sms')) {
            $smsTemplete = SmsTemplate::where('type_id', 35)->where('is_active', 1)->first(); //registration templete
            $msg = $smsTemplete->value . $code;
            $smsSend = $this->sendSMS($request->phone, $msg);
        }

        if ($emailSend == true || $smsSend == true) {
            return true;
        } else {
            return false;
        }
    }

    public function sendOtpForOrder($request, $type = Null)
    {
        $code = random_int(100000, 999999);

        $minutes = time() + (otp_configuration('code_validation_time') * 60);
        $validation_time = date('Y-m-d H:i:s', $minutes);

        if ($type == "resend") {
            Session::forget('otp');
            Session::forget('validation_time');
        }

        Session::put('otp', $code);
        Session::put('validation_time', $validation_time);
        Session::forget('code_validation_time');


        $emailSend = false;
        $smsSend = false;
        if (Str::contains(otp_configuration('otp_type_order'), 'email')) {
            $emailSend = $this->sendOtpByMailForOrder($request, $code);
        }
        if (Str::contains(otp_configuration('otp_type_order'), 'sms')) {
            if (auth()->user()) {
                $phone = $request->customer_phone;
            } else {
                $phone = $request->guest_shipping_phone;
            }
            $smsTemplete = SmsTemplate::where('type_id', 36)->where('is_active', 1)->first(); //order confirmation templete
            $msg = $smsTemplete->value . $code;
            $smsSend = $this->sendSMS($phone, $msg);
        }

        if ($emailSend == true || $smsSend == true) {
            return true;
        } else {
            return false;
        }
    }
}
