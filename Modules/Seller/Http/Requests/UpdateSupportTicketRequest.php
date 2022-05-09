<?php

namespace Modules\Seller\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupportTicketRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'subject' => 'required',
            'description' => 'required',
            'ticket_file.*' => 'nullable|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf',
            'priority_id' => 'required',
            'category_id' => 'required'
        ];
    }

    
    public function authorize()
    {
        return true;
    }
}
