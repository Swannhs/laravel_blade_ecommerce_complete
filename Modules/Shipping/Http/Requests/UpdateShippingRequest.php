<?php

namespace Modules\Shipping\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShippingRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'method_name' => 'required|max:255|unique:shipping_methods,method_name,'.$this->id,
            'phone' => 'required|unique:shipping_methods,phone,'.$this->id,
            'cost' => 'required',
            'shipment_time' => 'required',
            'method_logo' => 'nullable|mimes:jpg,jpeg,bmp,png'
        ];
    }

    
    public function authorize()
    {
        return true;
    }
}
