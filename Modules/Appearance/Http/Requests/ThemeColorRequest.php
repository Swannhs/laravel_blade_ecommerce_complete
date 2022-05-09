<?php

namespace Modules\Appearance\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemeColorRequest extends FormRequest
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
            'background_color' => 'required',
            'base_color' => 'required',
            'text_color' => 'required',
            'feature_color' => 'required',
            'footer_color' => 'required',
            'navbar_color' => 'required',
            'menu_color' => 'required',
            'border_color' => 'required',
            'success_color' => 'required',
            'warning_color' => 'required',
            'danger_color' => 'required',

        ];
    }
}
