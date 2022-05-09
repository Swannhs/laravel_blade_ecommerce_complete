<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }

    public function showLinkRequestForm(){
        if (isModuleActive('Otp') && otp_configuration('otp_on_password_reset')) {
            return view(theme('auth.reset_user_otp'));
        }
        return view(theme('auth.email'));
    }
    
}
