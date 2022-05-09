<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Modules\GeneralSetting\Entities\Currency;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }
    public function locale(Request $request)
    {

        if(auth()->check()){
            $userData = User::where('id', auth()->user()->id)->first();
            if(isset($request->currency)){

                $userData->currency_id = $request->currency;
                $currency = Currency::find($request->currency);
                $userData->currency_code = $currency->code;
            }
            $userData->lang_code = $request->lang;
            $userData->save();

        }else{

            if(isset($request->currency)){

                Session::put('currency',$request->currency);
            }

            Session::put('locale',$request->lang);

        }

        Toastr::success(__('common.updated_successfully'), __('common.success'));
        return redirect()->back();
    }
}
