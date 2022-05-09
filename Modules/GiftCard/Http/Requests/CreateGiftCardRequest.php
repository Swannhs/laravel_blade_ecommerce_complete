<?php

namespace Modules\GiftCard\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGiftCardRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'selling_price' => 'numeric|required',
            'discount' => 'numeric|nullable',
            'sku' => 'required|max:15|min:5|unique:gift_cards,sku',
            'status' => 'required',
            'thumbnail_image' => 'required|mimes:jpg,bmp,jpeg,png',
            'galary_image.*' => 'nullable|mimes:jpg,bmp,jpeg,png'
        ];
    }

    
    public function authorize()
    {
        return true;
    }
}
