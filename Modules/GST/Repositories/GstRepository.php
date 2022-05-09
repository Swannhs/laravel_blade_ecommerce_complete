<?php

namespace Modules\GST\Repositories;
use Modules\GST\Entities\GstTax;

class GstRepository
{
    public function getAllList()
    {
        return GstTax::latest()->get();
    }

    public function getActiveList()
    {
        return GstTax::Active()->get();
    }

    public function create($data)
    {
        return GstTax::create([
                    'name' => $data['name'],
                    'tax_percentage' => $data['rate'],
                    'is_active' => $data['status'],
                ]);
    }

    public function update($data, $id)
    {
        $gst =  GstTax::find($id);
        if($gst){
            return $gst->update([
                'name' => $data['name'],
                'tax_percentage' => $data['rate'],
                'is_active' => $data['status'],
            ]);
        }
        return false;
    }

    public function delete($id)
    {
        return GstTax::findOrFail($id)->delete();
    }

    public function updateConfiguration($data)
    {
        $previousRouteServiceProvier = base_path('Modules/GST/Resources/assets/config_files/config.json');
        $newRouteServiceProvier      = base_path('Modules/GST/Resources/assets/config_files/config.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);
        $jsonString = file_get_contents(base_path('Modules/GST/Resources/assets/config_files/config.json'));
        $config = json_decode($jsonString, true);
        $config['enable_gst'] = (!empty($data['enable_gst'])) ? $data['enable_gst'] : "0";
        $config['flat_tax_id'] = (!empty($data['flat_tax_id'])) ? $data['flat_tax_id'] : "0";
        foreach ($data as $key => $value) {
            if (is_array($data[$key])) {
                for ($i=0; $i < count($value); $i++) {
                    $config[$key][$i] = $value[$i];
                }
                $newJsonString = json_encode($config, JSON_PRETTY_PRINT);
                $newJsonString2 = json_encode($config[$key] , JSON_PRETTY_PRINT);
                file_put_contents(base_path('Modules/GST/Resources/assets/config_files/config.json'), stripslashes($newJsonString));
            }
        }
    }
}
