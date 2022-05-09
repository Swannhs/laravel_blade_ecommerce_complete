<?php

namespace Modules\Appearance\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
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
            'title' => 'required',
            'color_mode' => 'required',
            'background_type' => 'required',
            'background_image' => 'nullable|image',
            'background_color' => 'nullable',
            'base_color' => 'required',
            'solid_color' => 'nullable',
            'gradient_color_one' => 'nullable',
            'gradient_color_two' => 'nullable',
            'gradient_color_three' => 'nullable',
            'scroll_color' => 'required',
            'text_color' => 'required',
            'text_white' => 'required',
            'background_white' => 'required',
            'text_black' => 'required',
            'background_black' => 'required',
            'input_background' => 'required',
            'border_color' => 'required',
            'success_color' => 'required',
            'warning_color' => 'required',
            'danger_color' => 'required',
            'toastr_time' => 'required',
            'toastr_position' => 'required',
        ];
    }
}
