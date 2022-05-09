<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Marketing\Entities\ReferralCode;
use Modules\Marketing\Entities\ReferralUse;

class ReferralController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }
    
    public function referral(){
        $myCode = ReferralCode::where('user_id',auth()->user()->id)->first();
        if (auth()->user()->role->type != 'customer') {
            if(isset($myCode)){
                $referList = ReferralUse::where('referral_code',$myCode->referral_code)->latest()->get();
                return view('backEnd.pages.customer_data.referral',compact('myCode','referList'));
            }else{
                return view('backEnd.pages.customer_data.referral');
            }
        }
        else {
            if(isset($myCode)){
                $referList = ReferralUse::where('referral_code',$myCode->referral_code)->paginate(8);
                return view(theme('pages.profile.referral'),compact('myCode','referList'));
            }else{
                return view(theme('pages.profile.referral'));
            }
        }
    }
}
