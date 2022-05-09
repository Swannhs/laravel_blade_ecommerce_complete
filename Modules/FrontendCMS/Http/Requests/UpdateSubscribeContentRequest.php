<?php

namespace Modules\FrontendCMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscribeContentRequest extends FormRequest
{

    public function rules()
    {
        return [
            'title' => 'nullable|max:255',
            'subtitle' => 'nullable|max:255',
            'description' => 'nullable',
            'file' => 'nullable|mimes:jpeg,jpg,png,webp,bmp'
        ];
    }


    public function authorize()
    {
        return true;
    }
}
