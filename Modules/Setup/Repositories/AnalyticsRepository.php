<?php

namespace Modules\Setup\Repositories;

use Modules\GeneralSetting\Entities\BusinessSetting;
use Modules\Setup\Entities\AnalyticsTool;
use phpDocumentor\Reflection\PseudoTypes\True_;

class AnalyticsRepository{

    public function getAnalytics(){

        return AnalyticsTool::all();
    }

    public function getBusinessData(){

        return BusinessSetting::where('category_type','analytics_tool')->get();
    }

    public function googleAnalyticsUpdate($data){

        if (!empty($data['json'])) {
            $name = "service-account-credentials.json";
            $data['json']->move(public_path() . '/analytics/', $name);
            $previousFile = storage_path('service-account-credentials.json');
            $newFile      = public_path() . '/analytics/service-account-credentials.json';
            copy($newFile, $previousFile);
        }

        $business_data = BusinessSetting::find($data['business_id']);

        $business_data->update([
            'status' => isset($data['status'])?1:0
        ]);


        foreach ($data['types'] as $key => $type) {
            $this->overWriteEnvFile($type, $data[$type]);
        }
        return true;
    }

    public function facebookPixelUpdate($data){
        $business_data = BusinessSetting::find($data['business_id']);
        $analytics = AnalyticsTool::find($data['analytics_id']);

        $business_data->update([
            'status' => isset($data['status'])?1:0
        ]);

        $analytics->update([
            'facebook_pixel_id' => $data['facebook_pixel_id']
        ]);

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

}
