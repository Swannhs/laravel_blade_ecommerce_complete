<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_email' => 'required',
            'customer_phone' => 'required',
            'payment_method' => 'required',
            'customer_shipping_address' => 'required',
            'customer_billing_address' => 'required',
            'grand_total' => 'required',
            'sub_total' => 'required',
            'discount_total' => 'required',
            'shipping_total' => 'required',
            'number_of_package' => 'required',
            'number_of_item' => 'required',
            'payment_id' => 'required',
            'tax_total' => 'required',
            'shipping_cost' => 'required',
            'delivery_date' => 'required',
            'shipping_method' => 'required',
            'packagewiseTax' => 'required',
            'payment_method' => 'required',
        ];
    }
}
