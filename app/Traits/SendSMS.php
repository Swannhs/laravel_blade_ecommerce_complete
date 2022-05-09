<?php

namespace App\Traits;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Twilio\Rest\Client;
use \Modules\GeneralSetting\Entities\BusinessSetting;

trait SendSMS
{
    public function sendIndividualSMS($number, $text)
    {
        $apy_key = env('SMS_API_KEY');

        try {
            $soapClient = new \SoapClient("https://api2.onnorokomSMS.com/sendSMS.asmx?wsdl");
            $paramArray = array(
                'apiKey' => $apy_key,
                'messageText' =>  $text,
                'numberList' => $number,
                'smsType' => "TEXT",
                'maskName' => '',
                'campaignName' => '',
            );
            $value = $soapClient->__call("NumberSms", array($paramArray));
            return $value;
        } catch (\Exception $e) {
            return  $e->getMessage();
        }
    }

    function sendSMS($to, $text,$to_name='',$user_email='',$order_tracking_number = '',$secret_code='',$giftcard ='')
    {
        $text = str_replace("{USER_FIRST_NAME}", $to_name, $text);
        $text = str_replace("{USER_EMAIL}",$user_email, $text);
        $text = str_replace("{ORDER_TRACKING_NUMBER}", $order_tracking_number, $text);
        $text = str_replace("{WEBSITE_NAME}", app('general_setting')->site_title, $text);
        $text = str_replace("{GIFT_CARD_NAME}", $giftcard, $text);
        $text = str_replace("{SECRET_CODE}", $secret_code, $text);
        $return = true;

        if (BusinessSetting::where('type', 'Twillo')->first()->status) {
            if ($to) {

                $sid = env("TWILIO_SID"); // Your Account SID from www.twilio.com/console
                $token = env("TWILIO_TOKEN"); // Your Auth Token from www.twilio.com/console

                $client = new Client($sid, $token);
                try {
                    $message = $client->messages->create(
                        $to, // Text this number
                        array(
                            'from' => env('VALID_TWILLO_NUMBER'), // From a valid Twilio number
                            'body' => $text
                        )
                    );
                } catch (\Exception $e) {
                    $return = false;
                }
            }
        }
        elseif (BusinessSetting::where('type', 'Text to Local')->first()->status) {
            // Account details
            $apiKey = urlencode(env('TEXT_TO_LOCAL_API_KEY'));

            // Message details
            $numbers = array($to);
            $sender = urlencode(env('TEXT_TO_LOCAL_SENDER'));
            $message = rawurlencode($text);

            $numbers = implode(',', $numbers);

            // Prepare data for POST request
            $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

            // Send the POST request with cURL
            $ch = curl_init('https://api.txtlocal.com/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            // Process your response here
            $return = true;
            // return $response;
        }
        elseif (BusinessSetting::where('type', 'OtherSmsGateway')->first()->status) {
            $sms_settings = smsGatewaySetting();
            $response = false;
            if(empty($sms_settings['url'])){
                Toastr::info(__('common.set_sms_credentials'), __('common.info'));
                return $response;
            }

            $request_data = [
                $sms_settings['send_to_parameter_name'] => $to,
                $sms_settings['message_parameter_name'] => $text,
            ];

            if (!empty($sms_settings['parameter_1_key'])) {
                $request_data[$sms_settings['parameter_1_key']] = $sms_settings['parameter_1_value'];
            }
            if (!empty($sms_settings['parameter_2_key'])) {
                $request_data[$sms_settings['parameter_2_key']] = $sms_settings['parameter_2_value'];
            }
            if (!empty($sms_settings['parameter_3_key'])) {
                $request_data[$sms_settings['parameter_3_key']] = $sms_settings['parameter_3_value'];
            }
            if (!empty($sms_settings['parameter_4_key'])) {
                $request_data[$sms_settings['parameter_4_key']] = $sms_settings['parameter_4_value'];
            }
            if (!empty($sms_settings['parameter_5_key'])) {
                $request_data[$sms_settings['parameter_5_key']] = $sms_settings['parameter_5_value'];
            }
            if (!empty($sms_settings['parameter_6_key'])) {
                $request_data[$sms_settings['parameter_6_key']] = $sms_settings['parameter_6_value'];
            }
            if (!empty($sms_settings['parameter_7_key'])) {
                $request_data[$sms_settings['parameter_7_key']] = $sms_settings['parameter_7_value'];
            }
            if (!empty($sms_settings['parameter_8_key'])) {
                $request_data[$sms_settings['parameter_8_key']] = $sms_settings['parameter_8_value'];
            }
            if (!empty($sms_settings['parameter_9_key'])) {
                $request_data[$sms_settings['parameter_9_key']] = $sms_settings['parameter_9_value'];
            }
            if (!empty($sms_settings['parameter_10_key'])) {
                $request_data[$sms_settings['parameter_10_key']] = $sms_settings['parameter_10_value'];
            }
            $params = [];

            $user_name = array_search('username',$sms_settings);
            $password = array_search('password',$sms_settings);

            if($user_name && $password){
                $params['auth'] = [
                    $request_data[ $sms_settings[$user_name]],
                    $request_data[ $sms_settings[$password]],
                ];
                unset($request_data['username']);
                unset($request_data['password']);
            }
            $params['form_params'] = $request_data;

            $client = new \GuzzleHttp\Client();
            $method = strtolower($sms_settings['request_method']);
            if($method == 'get'){
                $response = $client->$method($sms_settings['url'] . '?'. http_build_query($request_data));
            }else{
                $response = $client->$method($sms_settings['url'],$params);
            }
            $return = $response;
        }
        return $return;

    }
}
