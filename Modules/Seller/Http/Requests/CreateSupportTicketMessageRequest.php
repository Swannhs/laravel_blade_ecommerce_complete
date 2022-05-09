<?php

namespace Modules\Seller\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSupportTicketMessageRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'text' => 'required',
            'ticket_file.*' => 'nullable|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf'
        ];
    }

    
    public function authorize()
    {
        return true;
    }
}
