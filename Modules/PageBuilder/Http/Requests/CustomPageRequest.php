<?php

namespace Modules\PageBuilder\Http\Requests;

use App\Traits\ValidationMessage;
use Illuminate\Foundation\Http\FormRequest;

class CustomPageRequest extends FormRequest
{
    use ValidationMessage;

    public function rules()
    {
        return [
            'title'=>'required|unique:dynamic_pages,title,'.$this->id,
            'slug'=>'required|unique:dynamic_pages,slug,'.$this->id,
        ];

    }

    public function authorize()
    {
        return true;
    }
}
