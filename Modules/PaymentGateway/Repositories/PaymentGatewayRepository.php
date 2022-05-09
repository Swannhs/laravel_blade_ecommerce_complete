<?php

namespace Modules\PaymentGateway\Repositories;

use App\Traits\ImageStore;
use Modules\GeneralSetting\Entities\BusinessSetting;
use Modules\PaymentGateway\Entities\PaymentMethod;
use Illuminate\Support\Arr;

class PaymentGatewayRepository
{
    use ImageStore;
    public function gateway_activations()
    {
        return PaymentMethod::all();
    }

    public function gateway_active()
    {
        return PaymentMethod::where('active_status', 1)->get();
    }

    public function update_gateway_credentials(array $data)
    {

        $gateway = PaymentMethod::find($data['id']);
        if (!empty($data['logo'])) {
            $data = Arr::add($data, 'logo_src', $this->PaymentLogo($data['logo'], 36, 120));
            $this->deleteImage($gateway->logo);
        }
        if (!empty($data['logo_src'])) {
            $gateway->logo = $data['logo_src'];
        }
        $gateway->save();
        foreach ($data['types'] as $key => $type) {
            $this->overWriteEnvFile($type, $data[$type]);
        }
    }

    public function update_activation(array $data)
    {
        return PaymentMethod::where('id',$data['id'])->update([
            'active_status' => $data['status'],
        ]);
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

    public function findById($id)
    {
        return PaymentMethod::where('id', $id)->where('active_status', 1)->first();
    }

    public function update(array $data, $id)
    {
        //
    }

    public function delete($id)
    {
        //
    }
}
