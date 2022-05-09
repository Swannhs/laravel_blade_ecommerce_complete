<?php

namespace Modules\GeneralSetting\Repositories;

use Illuminate\Support\Facades\Cache;
use Modules\GeneralSetting\Entities\BusinessSetting;
use Modules\GeneralSetting\Entities\GeneralSetting;
use Modules\GeneralSetting\Entities\DateFormat;
use Modules\GeneralSetting\Entities\SmsGatewaySetting;
use Modules\GeneralSetting\Entities\TimeZone;

class GeneralSettingRepository
{
    public function all()
    {
        return GeneralSetting::first();
    }

    public function getVerificationNotificationAll()
    {
        return BusinessSetting::where('category_type', 'verification and notifications')->get();
    }

    public function getVendorConfigurationAll()
    {
        return BusinessSetting::where('category_type', 'vendor_configuration')->get();
    }

    public function getSmsGatewaysAll()
    {
        return BusinessSetting::where('category_type', 'sms_gateways')->get();
    }

    public function getLanguagesAll()
    {
        return BusinessSetting::where('category_type', 'sms_gateways')->get();
    }

    public function getDateFormatsAll()
    {
        return DateFormat::all();
    }

    public function getTimezonesAll()
    {
        return TimeZone::all();
    }

    public function getGeneralInfoDetails()
    {
        return GeneralSetting::first();
    }

    public function update(array $data)
    {
        return GeneralSetting::first()->update($data);
    }

    public function updateShopLink($shopLinkUrl)
    {
        return GeneralSetting::first()->update(['shop_link_banner'=>$shopLinkUrl]);
    }

    public function updateActivationStatus($data)
    {
        return BusinessSetting::where('id',$data['id'])->update([
            'status' => $data['status'],
        ]);
    }

    public function updateActivationSmsStatus($data)
    {


        if($data['action'] == 'other'){
            $row = SmsGatewaySetting::first();
            if($row){
                SmsGatewaySetting::where('id',$row->id)->update([
                    'url'=>isset($data['url'])?$data['url']:null,
                    'send_to_parameter_name'=>isset($data['send_to_parameter_name'])?$data['send_to_parameter_name']:null,
                    'message_parameter_name'=>isset($data['message_parameter_name'])?$data['message_parameter_name']:null,
                    'request_method'=>isset($data['request_method'])?$data['request_method']:null,
                    'parameter_1_key'=>isset($data['parameter_1_key'])?$data['parameter_1_key']:null,
                    'parameter_2_key'=>isset($data['parameter_2_key'])?$data['parameter_2_key']:null,
                    'parameter_3_key'=>isset($data['parameter_3_key'])?$data['parameter_3_key']:null,
                    'parameter_4_key'=>isset($data['parameter_4_key'])?$data['parameter_4_key']:null,
                    'parameter_5_key'=>isset($data['parameter_5_key'])?$data['parameter_5_key']:null,
                    'parameter_6_key'=>isset($data['parameter_6_key'])?$data['parameter_6_key']:null,
                    'parameter_7_key'=>isset($data['parameter_7_key'])?$data['parameter_7_key']:null,
                    'parameter_8_key'=>isset($data['parameter_8_key'])?$data['parameter_8_key']:null,
                    'parameter_9_key'=>isset($data['parameter_9_key'])?$data['parameter_9_key']:null,
                    'parameter_10_key'=>isset($data['parameter_10_key'])?$data['parameter_10_key']:null,
                    'parameter_1_value'=>isset($data['parameter_1_value'])?$data['parameter_1_value']:null,
                    'parameter_2_value'=>isset($data['parameter_2_value'])?$data['parameter_2_value']:null,
                    'parameter_3_value'=>isset($data['parameter_3_value'])?$data['parameter_3_value']:null,
                    'parameter_4_value'=>isset($data['parameter_4_value'])?$data['parameter_4_value']:null,
                    'parameter_5_value'=>isset($data['parameter_5_value'])?$data['parameter_5_value']:null,
                    'parameter_6_value'=>isset($data['parameter_6_value'])?$data['parameter_6_value']:null,
                    'parameter_7_value'=>isset($data['parameter_7_value'])?$data['parameter_7_value']:null,
                    'parameter_8_value'=>isset($data['parameter_8_value'])?$data['parameter_8_value']:null,
                    'parameter_9_value'=>isset($data['parameter_9_value'])?$data['parameter_9_value']:null,
                    'parameter_10_value'=>isset($data['parameter_10_value'])?$data['parameter_10_value']:null,
                ]);
            }else{
                SmsGatewaySetting::create([
                    'url'=>isset($data['url'])?$data['url']:null,
                    'send_to_parameter_name'=>isset($data['send_to_parameter_name'])?$data['send_to_parameter_name']:null,
                    'message_parameter_name'=>isset($data['message_parameter_name'])?$data['message_parameter_name']:null,
                    'request_method'=>isset($data['request_method'])?$data['request_method']:null,
                    'parameter_1_key'=>isset($data['parameter_1_key'])?$data['parameter_1_key']:null,
                    'parameter_2_key'=>isset($data['parameter_2_key'])?$data['parameter_2_key']:null,
                    'parameter_3_key'=>isset($data['parameter_3_key'])?$data['parameter_3_key']:null,
                    'parameter_4_key'=>isset($data['parameter_4_key'])?$data['parameter_4_key']:null,
                    'parameter_5_key'=>isset($data['parameter_5_key'])?$data['parameter_5_key']:null,
                    'parameter_6_key'=>isset($data['parameter_6_key'])?$data['parameter_6_key']:null,
                    'parameter_7_key'=>isset($data['parameter_7_key'])?$data['parameter_7_key']:null,
                    'parameter_8_key'=>isset($data['parameter_8_key'])?$data['parameter_8_key']:null,
                    'parameter_9_key'=>isset($data['parameter_9_key'])?$data['parameter_9_key']:null,
                    'parameter_10_key'=>isset($data['parameter_10_key'])?$data['parameter_10_key']:null,
                    'parameter_1_value'=>isset($data['parameter_1_value'])?$data['parameter_1_value']:null,
                    'parameter_2_value'=>isset($data['parameter_2_value'])?$data['parameter_2_value']:null,
                    'parameter_3_value'=>isset($data['parameter_3_value'])?$data['parameter_3_value']:null,
                    'parameter_4_value'=>isset($data['parameter_4_value'])?$data['parameter_4_value']:null,
                    'parameter_5_value'=>isset($data['parameter_5_value'])?$data['parameter_5_value']:null,
                    'parameter_6_value'=>isset($data['parameter_6_value'])?$data['parameter_6_value']:null,
                    'parameter_7_value'=>isset($data['parameter_7_value'])?$data['parameter_7_value']:null,
                    'parameter_8_value'=>isset($data['parameter_8_value'])?$data['parameter_8_value']:null,
                    'parameter_9_value'=>isset($data['parameter_9_value'])?$data['parameter_9_value']:null,
                    'parameter_10_value'=>isset($data['parameter_10_value'])?$data['parameter_10_value']:null,
                ]);
            }
            Cache::forget('sms_gateway_setting');
            $setting = SmsGatewaySetting::first();
            if($setting){
                $r_data = collect($setting->toArray())->except(['id','created_at','updated_at'])->all();
                Cache::rememberForever('sms_gateway_setting', function () use($r_data) {
                    return $r_data;
                });
            }
        }else{
            foreach ($this->getSmsGatewaysAll() as $key => $sms_gateway) {
                $sms_gateway->status = 0;
                $sms_gateway->save();
            }

            foreach ($data['types'] as $key => $type) {
                $this->overWriteEnvFile($type, $data[$type]);
            }
        }


        BusinessSetting::where('id',$data['sms_gateway_id'])->update([
            'status' => 1,
        ]);

        return true;
    }

    public function update_smtp_gateway_credential($data)
    {
        $general_setting = $this->getGeneralInfoDetails();
        $general_setting->mail_protocol = $data['mail_gateway'];
        $general_setting->save();

        foreach ($data['types'] as $key => $type) {
            $this->overWriteEnvFile($type, $data[$type]);
        }

        return true;
    }

    public function overWriteEnvFile($type, $val)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            $val = '"'.trim($val).'"';
            if(is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0){
                file_put_contents($path, str_replace(
                    $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
                ));
            }
            else{
                file_put_contents($path, file_get_contents($path)."\r\n".$type.'='.$val);
            }
        }

    }

    public static function envUpdate($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {

            file_put_contents($path, str_replace(
                $key . '=' . env($key), $key . '=' . $value, file_get_contents($path)
            ));
        }
    }
    public function updateEmailFooterTemplate($data)
    {
        $general_setting = GeneralSetting::first()->update([
            'mail_footer' => $data['mail_footer']
        ]);
        return true;

    }

}
