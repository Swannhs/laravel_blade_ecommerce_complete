<?php

namespace Modules\SupportTicket\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupportTicketUpdateRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'subject' => 'required',
            'description' => 'required',
            'refer_id' => 'nullable',
            'ticket_file.*' => 'nullable|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf',
            'priority_id' => 'required',
            'category_id' => 'required',
            'status' => 'required'
        ];
    }

    
    public function authorize()
    {
        return true;
    }
}
