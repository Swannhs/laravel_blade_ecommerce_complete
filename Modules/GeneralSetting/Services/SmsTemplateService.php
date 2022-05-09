<?php
namespace Modules\GeneralSetting\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\GeneralSetting\Repositories\SmsTemplateRepository;
use Illuminate\Support\Arr;

class SmsTemplateService
{
    protected $smsTemplateRepository;

    public function __construct(SmsTemplateRepository  $smsTemplateRepository)
    {
        $this->smsTemplateRepository = $smsTemplateRepository;
    }

    public function getSmsTemplates()
    {
        return $this->smsTemplateRepository->getSmsTemplates();
    }

    public function getSmsTemplateTypes()
    {
        return $this->smsTemplateRepository->getSmsTemplateTypes();
    }

    public function createTemplate($data)
    {
        foreach ($data['reciepnt_type'] as $reciepnt) {
            if ($reciepnt == "customer") {
                $data['reciepnt'][0] = "customer";
            }elseif ($reciepnt == "seller") {
                $data['reciepnt'][1] = "seller";
            }
        }
        return $this->smsTemplateRepository->createTemplate($data);
    }

    public function updateSmsTemplate($data, $id)
    {
        foreach ($data['reciepnt_type'] as $reciepnt) {
            if ($reciepnt == "customer") {
                $data['reciepnt'][0] = "customer";
            }elseif ($reciepnt == "seller") {
                $data['reciepnt'][1] = "seller";
            }
        }
        return $this->smsTemplateRepository->updateSmsTemplate($data, $id);
    }

    public function updateSmsTemplateStatus($data)
    {
        return $this->smsTemplateRepository->updateSmsTemplateStatus($data);
    }

    public function find($id)
    {
        return $this->smsTemplateRepository->find($id);
    }
}
