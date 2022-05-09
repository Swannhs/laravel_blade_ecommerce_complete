<?php

namespace Modules\FrontendCMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMerchantContentRequest extends FormRequest
{

    public function rules()
    {
        return [
            'mainTitle' => 'required',
            'subTitle' => 'required',
            'slug' => 'required|unique:merchant_contents,slug,'.$this->id,
            'Maindescription' => 'required',
            'pricing' => 'required',
            'benifitTitle' => 'required',
            'benifitDescription' => 'required',
            'howitworkTitle' => 'required',
            'howitworkDescription' => 'required',
            'pricingTitle' => 'required',
            'pricingDescription' => 'required',
            'sellerRegistrationTitle' => 'required',
            'sellerRegistrationDescription' => 'required',
            'pricingDescription' => 'required',
            'queryTitle' => 'required',
            'queryDescription' => 'required',
            'faqTitle' => 'required',
            'faqDescription' => 'required',
        ];
    }


    public function authorize()
    {
        return true;
    }
}
