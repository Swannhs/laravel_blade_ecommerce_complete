<?php

namespace Modules\Shipping\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateShippingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'method_name' => 'required|max:255|unique:shipping_methods,method_name',
            'phone' => 'required|unique:shipping_methods',
            'cost' => 'required',
            'shipment_time' => 'required',
            'method_logo' => 'nullable|mimes:jpg,jpeg,bmp,png'

        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
