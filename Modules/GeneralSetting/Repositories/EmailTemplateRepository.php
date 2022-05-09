<?php

namespace Modules\GeneralSetting\Repositories;

use Modules\GeneralSetting\Entities\EmailTemplate;
use Modules\GeneralSetting\Entities\EmailTemplateType;

class EmailTemplateRepository
{
    public function getEmailTemplates()
    {
        return EmailTemplate::orderBy('type_id', 'asc')->get();
    }

    public function getEmailTemplateTypes()
    {
        return EmailTemplateType::all();
    }

    public function createTemplate($data)
    {
        $relatable_type = null;
        $relatable_id = null;
        $reciepnt_type = ["customer"];

        if ($data['type_id'] == 7) {
            $relatable_type = "Modules\OrderManage\Entities\DeliveryProcess";
            $relatable_id = $data['delivery_process_id'];
        }
        if ($data['type_id'] == 8) {
            $relatable_type = "Modules\Refund\Entities\RefundProcess";
            $relatable_id = $data['refund_process_id'];
        }

        EmailTemplate::create([
            'type_id' => $data['type_id'],
            'subject' => $data['subject'],
            'value' => $data['template'],
            'reciepnt_type' => (!empty($data['reciepnt'])) ? json_encode($data['reciepnt']) : json_encode($reciepnt_type),
            'relatable_type' => $relatable_type,
            'relatable_id' => $relatable_id,
        ]);
    }

    public function find($id)
    {
        return EmailTemplate::findorFail($id);
    }

    public function updateEmailTemplate($data, $id)
    {
        $reciepnt_type = ["customer"];
        return EmailTemplate::findorFail($id)->update([
            'subject' => $data['subject'],
            'reciepnt_type' => (!empty($data['reciepnt'])) ? json_encode($data['reciepnt']) : json_encode($reciepnt_type),
            'value' => $data['template']
        ]);
    }

    public function updateEmailTemplateStatus($data)
    {
        $template = EmailTemplate::findorFail($data['id']);
        $active_check = EmailTemplate::where('type_id', $template->type_id)->where('is_active', 1)->where('id', '!=', $template->id)->first();
        if($data['status'] == 0 && !$active_check){
            return 'not_possible';

        }
        $template->update([
            'is_active' => $data['status']
        ]);

        $otherLists = EmailTemplate::where('type_id', $template->type_id)->where('id', '!=', $template->id)->get();
        if(count($otherLists) > 0){
            foreach($otherLists as $tem){
                $tem->update([
                    'is_active' => 0
                ]);
            }
        }
        return 1;

    }
}

