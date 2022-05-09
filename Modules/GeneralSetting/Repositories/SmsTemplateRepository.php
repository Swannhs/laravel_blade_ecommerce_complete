<?php

namespace Modules\GeneralSetting\Repositories;

use Modules\GeneralSetting\Entities\SmsTemplate;
use Modules\GeneralSetting\Entities\SmsTemplateType;

class SmsTemplateRepository
{
    public function getSmsTemplates()
    {
        return SmsTemplate::orderBy('type_id', 'asc')->get();
    }

    public function getSmsTemplateTypes()
    {
        return SmsTemplateType::all();
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
        if ($data['type_id'] == 14) {
            $relatable_type = "Modules\Refund\Entities\RefundProcess";
            $relatable_id = $data['refund_process_id'];
        }

        SmsTemplate::create([
            'type_id' => $data['type_id'],
            'subject' => $data['subject'],
            'value' => $data['template'],
            'reciepnt_type' => (!empty($data['reciepnt'])) ? json_encode($data['reciepnt']) : json_encode($reciepnt_type),
            'relatable_type' => $relatable_type,
            'relatable_id' => $relatable_id,
        ]);
        return true;
    }

    public function find($id)
    {
        return SmsTemplate::findorFail($id);
    }

    public function updateSmsTemplate($data, $id)
    {
        $reciepnt_type = ["customer"];
        return SmsTemplate::findorFail($id)->update([
            'subject' => $data['subject'],
            'reciepnt_type' => (!empty($data['reciepnt'])) ? json_encode($data['reciepnt']) : json_encode($reciepnt_type),
            'value' => $data['template']
        ]);
    }

    public function updateSmsTemplateStatus($data)
    {
        $template = SmsTemplate::findorFail($data['id']);
        $active_check = SmsTemplate::where('type_id', $template->type_id)->where('is_active', 1)->where('id', '!=', $template->id)->first();
        if($data['status'] == 0 && !$active_check){
            return 'not_possible';

        }
        $template->update([
            'is_active' => $data['status']
        ]);

        $otherLists = SmsTemplate::where('type_id', $template->type_id)->where('id', '!=', $template->id)->get();
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

