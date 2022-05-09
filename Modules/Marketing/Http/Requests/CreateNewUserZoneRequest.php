<?php

namespace Modules\Marketing\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateNewUserZoneRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'sub_title' => 'required|max:255',
            'background_color' =>'nullable',
            'text_color' =>'nullable',
            'banner_image' =>'nullable',
            'product_navigation_label' => 'required',
            'coupon_navigation_label' => 'required',
            'category_navigation_label' => 'required',
            'product' => 'required',
            'category' => 'required',
            'coupon_category' => 'required'
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
