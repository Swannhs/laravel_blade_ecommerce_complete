<?php

namespace Modules\GiftCard\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGiftCardRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'selling_price' => 'numeric|required',
            'discount' => 'numeric|nullable',
            'sku' => 'required|max:15|min:5|unique:gift_cards,sku,'.$this->id,
            'status' => 'required',
            'thumbnail_image' => 'nullable|mimes:jpg,bmp,jpeg,png',
            'galary_image.*' => 'nullable|mimes:jpg,bmp,jpeg,png'
        ];
    }

    
    public function authorize()
    {
        return true;
    }
}
