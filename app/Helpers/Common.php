<?php

use App\Models\OrderProductDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Modules\GeneralSetting\Entities\BusinessSetting;
use Modules\GeneralSetting\Entities\Currency;
use Modules\GeneralSetting\Entities\GeneralSetting;
use Modules\Otp\Entities\OtpConfiguration;
use Modules\Product\Entities\Product;
use Modules\Seller\Entities\SellerProduct;

if (! function_exists('showStatus')) {
        function showStatus($status)
        {
            if($status == 1){
                return 'Active';
            }
            return 'Inactive';
        }
    }


    if (! function_exists('permissionCheck')) {
        function permissionCheck($route_name)
        {
            if(auth()->check()){
                if(auth()->user()->role->type == "superadmin"){
                    return TRUE;
                }elseif (auth()->user()->role->type == "custom") {
                    if(auth()->user()->permissions->contains('route',$route_name)){
                        return TRUE;
                    }else{
                        return FALSE;
                    }
                }else{
                    $roles = app('permission_list');
                    $role = $roles->where('id',auth()->user()->role_id)->first();
                    if($role != null && $role->permissions->contains('route',$route_name)){
                        return TRUE;
                    }else{
                        return FALSE;
                    }
                }
            }
            return FALSE ;
        }
    }

    if (! function_exists('single_price')) {
        function single_price($price)
        {
            if(app('user_currency') != null){
                if(app('general_setting')->currency_symbol_position == 'left'){
                    return app('user_currency')->symbol . number_format(($price * app('user_currency')->convert_rate), app('general_setting')->decimal_limit);
                }
                elseif(app('general_setting')->currency_symbol_position == 'left_with_space'){
                    return app('user_currency')->symbol ." ". number_format(($price * app('user_currency')->convert_rate), app('general_setting')->decimal_limit);
                }
                elseif(app('general_setting')->currency_symbol_position == 'right'){
                    return number_format(($price * app('user_currency')->convert_rate), app('general_setting')->decimal_limit).app('user_currency')->symbol;
                }
                elseif(app('general_setting')->currency_symbol_position == 'right_with_space'){
                    return number_format(($price * app('user_currency')->convert_rate), app('general_setting')->decimal_limit). " " . app('user_currency')->symbol;
                } else{
                    return app('user_currency')->symbol ." ". number_format(($price * app('user_currency')->convert_rate), app('general_setting')->decimal_limit);
                }

            }
            if(app('general_setting')->currency_symbol != null){
                if(app('general_setting')->currency_symbol_position == 'left'){
                    return app('general_setting')->currency_symbol . number_format($price, app('general_setting')->decimal_limit);
                }
                elseif(app('general_setting')->currency_symbol_position == 'left_with_space'){
                    return app('general_setting')->currency_symbol ." ". number_format($price, app('general_setting')->decimal_limit);
                }
                elseif(app('general_setting')->currency_symbol_position == 'right'){
                    return number_format($price, app('general_setting')->decimal_limit) . app('general_setting')->currency_symbol;
                }
                elseif(app('general_setting')->currency_symbol_position == 'right_with_space'){
                    return number_format($price, app('general_setting')->decimal_limit) ." ".app('general_setting')->currency_symbol;
                }else{
                    return app('general_setting')->currency_symbol ." ". number_format($price, app('general_setting')->decimal_limit);
                }

            }else {
                return '$ '.number_format($price, 2);
            }
        }
    }


    if (! function_exists('step_decimal')) {
        function step_decimal(){
            $step_value = app('general_setting')->decimal_limit;
            if($step_value > 1){
                $process_value = '0.';
                for($i=1;$i<=$step_value;$i++){
                    $process_value .= '0';
                }
                return doubleval($process_value.'1');
            }
            return 0;
        }
    }



    //returns combinations of customer choice options array
    if (! function_exists('combinations')) {
        function combinations($arrays) {
            $result = array(array());
            foreach ($arrays as $property => $property_values) {
                $tmp = array();
                foreach ($result as $result_item) {
                    foreach ($property_values as $property_value) {
                        $tmp[] = array_merge($result_item, array($property => $property_value));
                    }
                }
                $result = $tmp;
            }
            return $result;
        }
    }

    if(!function_exists('product_attribute_editable')){
        function product_attribute_editable($product_id){
            $seller_product_exsist = SellerProduct::whereHas('product', function($query) use ($product_id){
                return $query->where('product_id', $product_id)->where('user_id','!=',1);
            })->pluck('id');
            $order_exsist = OrderProductDetail::where('type', 'product')->whereHas('seller_product_sku', function($query) use($product_id){
                return $query->whereHas('product', function($q) use($product_id){
                    return $q->whereHas('product', function($q1) use($product_id){
                        return $q1->where('product_id', $product_id);
                    });
                });
            })->pluck('id');
            if($seller_product_exsist->count() || $order_exsist->count()){
                return false;
            }
            return true;
        }
    }

    if (!function_exists('dateConvert')) {

        function dateConvert($input_date){
            try {
                $system_date_format = session()->get('system_date_format');

                if (empty($system_date_format)) {
                    $system_date_format = app('general_setting')->dateFormat->format;
                    session()->put('system_date_format', $system_date_format);
                    return date_format(date_create($input_date), $system_date_format);
                } else {

                return date_format(date_create($input_date), $system_date_format);

                }
            } catch (\Throwable $th) {

                return $input_date;
            }
        }
    }


if (! function_exists('gateway_name')) {
    function gateway_name($number) {
        if ($number == 1) {
            return "Cash On Delivery";
        }elseif ($number == 2) {
            return "Wallet";
        }elseif ($number == 3) {
            return "Paypal";
        }elseif ($number == 4) {
            return "Stripe";
        }elseif ($number == 5) {
            return "PayStack";
        }elseif ($number == 6) {
            return "RazorPay";
        }elseif ($number == 7) {
            return "Bank";
        }elseif ($number == 8) {
            return "Instamojo";
        }elseif ($number == 9) {
            return "PayTm";
        }else {
            return "No Gateway";
        }
    }
}

if (! function_exists('wallet_balance')) {
    function wallet_balance(){
        $deposite = auth()->user()->wallet_balances->where('type', 'Deposite')->sum('amount');
        $refund_back = auth()->user()->wallet_balances->where('type', 'Refund Back')->sum('amount');
        $expensed = auth()->user()->wallet_balances->where('type', 'Cart Payment')->sum('amount');
        $rest_money = $deposite + $refund_back - $expensed;
        return $rest_money;
    }
}

if (! function_exists('seller_wallet_balance_pending')) {
    function seller_wallet_balance_pending(){
        $deposite = auth()->user()->wallet_balances->where('type', 'Deposite')->where('status', 0)->sum('amount');
        $withdraw = auth()->user()->wallet_balances->where('type', 'Withdraw')->where('status', 0)->sum('amount');
        $expense = auth()->user()->wallet_balances->where('type', 'Refund')->where('status', 0)->sum('amount');
        $income = auth()->user()->wallet_balances->where('type', 'Sale Payment')->where('status', 0)->sum('amount');
        $rest_money = $deposite + $income - $expense - $withdraw;
        return $rest_money;
    }
}

if (! function_exists('seller_wallet_balance_running')) {
    function seller_wallet_balance_running(){

        // New
        $deposite = auth()->user()->wallet_balances->where('type', 'Deposite')->where('status', 1)->sum('amount');
        $withdraw = auth()->user()->wallet_balances->where('type', 'Withdraw')->where('status', 1)->sum('amount');
        $expense = auth()->user()->wallet_balances->where('type', 'Refund')->where('status', 1)->sum('amount');
        $income = auth()->user()->wallet_balances->where('type', 'Sale Payment')->where('status', 1)->sum('amount');
        $expensed = auth()->user()->wallet_balances->where('status',1)->where('type', 'Cart Payment')->sum('amount');
        $rest_money = $deposite + $income - $expense - $withdraw -$expensed;
        return $rest_money;

    }
}

if (!function_exists('filterDateFormatingForSearchQuery')) {

    function filterDateFormatingForSearchQuery($value)
    {
        $data = explode("-",$foo = preg_replace('/\s+/', ' ', $value));
        return [Carbon::parse($data[0])->format('Y-m-d'),Carbon::parse($data[1])->format('Y-m-d')];
    }
}

if (!function_exists('barcodeList')) {
    function barcodeList()
    {
        return $array = array("C39", "C39+", "C39E", "C39E+", "C93", "I25", "POSTNET", "EAN2", "EAN5", "PHARMA2T");
    }
}

if (!function_exists('auto_approve_seller')) {
    function auto_approve_seller()
    {
        $autoApproveSetting = GeneralSetting::first();
        return $autoApproveSetting->auto_approve_seller;
    }
}
if (!function_exists('auto_approve_seller_review')) {
    function auto_approve_seller_review()
    {
        $autoApproveSetting = GeneralSetting::first();
        return $autoApproveSetting->auto_approve_seller_review;
    }
}
if (!function_exists('auto_approve_product_review')) {
    function auto_approve_product_review()
    {
        $autoApproveSetting = GeneralSetting::first();
        return $autoApproveSetting->auto_approve_product_review;
    }
}
if (!function_exists('otp_configuration')) {
    function otp_configuration($key)
    {
        if(isModuleActive('Otp')){
            $otpConfiguration = OtpConfiguration::where('key',$key)->first();
            return $otpConfiguration->value ?? NULL;
        }
        return NULL;

    }
}


if (!function_exists('smsGatewaySetting')) {
    function smsGatewaySetting()
    {

        try {
            if (Cache::has('sms_gateway_setting')) {
                $sms_gate_way =  Cache::get('sms_gateway_setting');
                return $sms_gate_way;
            } else {
                $setting = \Modules\GeneralSetting\Entities\SmsGatewaySetting::first();
                if($setting){
                    $data = collect($setting->toArray())->except(['id','created_at','updated_at'])->all();
                    Cache::forget('sms_gateway_setting');
                    Cache::rememberForever('sms_gateway_setting', function () use($data) {
                        return $data;
                    });
                    $sms_gate_way =  Cache::get('sms_gateway_setting');
                    return $sms_gate_way;
                }
                return false;

            }

        } catch (Exception $exception) {
            return false;
        }
    }
}



if (!function_exists('validationMessage')) {
    function validationMessage($validation_rules)
    {
        $message = [];
        foreach ($validation_rules as $attribute => $rules) {

            if (is_array($rules)) {
                $single_rule = $rules;
            } else {
                $single_rule = explode('|', $rules);
            }

            foreach ($single_rule as $rule) {
                $string = explode(':', $rule);
                $message [$attribute . '.' . $string[0]] = __('validation.' . $attribute . '.' . $string[0]);
            }
        }

        return $message;
    }
}

if (!function_exists('showDate')) {
    function showDate($date)
    {
        try {
            if (!$date) {
                return '';
            }
            return date(app('general_setting')->dateFormat->format, strtotime($date));
        } catch (\Exception $e) {
            return '';
        }
    }
}


if (!function_exists('showImage')) {
    function showImage($path)
    {
        if($path){
            if(strpos($path, 'amazonaws.com') != false){
                return $path;
            }else{
                return asset(asset_path($path));
            }

        }else{
            return null;
        }

    }
}

if (!function_exists('activeFileStorage')) {
    function activeFileStorage()
    {
        try {
            if (Cache::has('file_storage')) {
                $file_storage =  Cache::get('file_storage');
                return $file_storage;
            } else {
                $row = BusinessSetting::where('category_type','file_storage')->where('status',1)->first();
                if($row){
                    Cache::forget('file_storage');
                    Cache::rememberForever('file_storage', function () use($row) {
                        return $row->type;
                    });
                    $file_storage =  Cache::get('file_storage');
                    return $file_storage;
                }else{
                    return 'Local';
                }
            }

        } catch (Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('putEnvConfigration')) {
    function putEnvConfigration($envKey, $envValue)
    {

        $value = '"' . $envValue . '"';
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $str .= "\n";
        $keyPosition = strpos($str, "{$envKey}=");

        if (is_bool($keyPosition)) {

            $str .= $envKey . '="' . $envValue . '"';

        } else {
            $endOfLinePosition = strpos($str, "\n", $keyPosition);
            $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
            $str = str_replace($oldLine, "{$envKey}={$value}", $str);

            $str = substr($str, 0, -1);
        }

        if (!file_put_contents($envFile, $str)) {
            return false;
        } else {
            return true;
        }

    }
}

if (!function_exists('currencyCode')) {
    function currencyCode()
    {

        $currency_code = app('general_setting')->currency_code;

        if(\Session::has('currency')){
            $currency = \Modules\GeneralSetting\Entities\Currency::where('id', session()->get('currency'))->first();
            $currency_code = $currency->code;
        }
        if(auth()->check()){
            $currency_code = auth()->user()->currency_code;
        }

        return $currency_code;

    }
}
