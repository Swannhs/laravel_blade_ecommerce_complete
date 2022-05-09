<?php

namespace Modules\FrontendCMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeatureRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'title' => 'required',
            'slug' => 'required|unique:features,slug,'.$this->id,
            'icon' => 'required',
            'status' => 'required',
        ];
    }

    
    public function authorize()
    {
        return true;
    }
}
