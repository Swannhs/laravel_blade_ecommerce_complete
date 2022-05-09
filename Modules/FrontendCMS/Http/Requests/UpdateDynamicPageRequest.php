<?php

namespace Modules\FrontendCMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDynamicPageRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'title' => 'required',
            'slug' => 'required|unique:dynamic_pages,slug,'.$this->id,
            'description' => 'required',
        ];
    }
    

    
    public function authorize()
    {
        return true;
    }
}
