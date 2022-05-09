<?php

namespace Modules\FrontendCMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutUsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mainTitle' => 'required',
            'subTitle' => 'required',
            'mainDescription' => 'required',
            'benifitTitle' => 'required',
            'benifitDescription' => 'required',
            'sellingTitle' => 'required',
            'sellingDescription' => 'required',
            'slug' => 'required|unique:about_us,slug,'.$this->id, 
            'price' => 'required'
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
