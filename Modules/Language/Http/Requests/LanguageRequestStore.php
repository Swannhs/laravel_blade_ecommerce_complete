<?php

namespace Modules\Language\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Session;

class LanguageRequestStore extends FormRequest
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
        Session::put('language_form', 'store_form');
        return [
              "name" => "required",
              "native" => "required",
              "code" => [
                'required',
                Rule::unique('languages', 'code')->ignore($this->id)
            ],
        ];
    }
}
