<?php

namespace Modules\Language\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Session;
use Illuminate\Validation\Rule;

class LanguageRequestUpdate extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        Session::put('language_form', 'update_form');
        return [
            "name" => "required",
            "native" => "required",
            "code" => [
                'required',
                Rule::unique('languages', 'code')->ignore($this->id)
            ],
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
