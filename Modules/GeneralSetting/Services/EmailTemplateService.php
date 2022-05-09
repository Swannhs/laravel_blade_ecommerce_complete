<?php
namespace Modules\GeneralSetting\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\GeneralSetting\Repositories\EmailTemplateRepository;
use Illuminate\Support\Arr;

class EmailTemplateService
{
    protected $emailTemplateRepository;

    public function __construct(EmailTemplateRepository  $emailTemplateRepository)
    {
        $this->emailTemplateRepository = $emailTemplateRepository;
    }

    public function getEmailTemplates()
    {
        return $this->emailTemplateRepository->getEmailTemplates();
    }

    public function getEmailTemplateTypes()
    {
        return $this->emailTemplateRepository->getEmailTemplateTypes();
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
        return $this->emailTemplateRepository->createTemplate($data);
    }

    public function updateEmailTemplate($data, $id)
    {
        foreach ($data['reciepnt_type'] as $reciepnt) {
            if ($reciepnt == "customer") {
                $data['reciepnt'][0] = "customer";
            }elseif ($reciepnt == "seller") {
                $data['reciepnt'][1] = "seller";
            }
        }
        return $this->emailTemplateRepository->updateEmailTemplate($data, $id);
    }

    public function updateEmailTemplateStatus($data)
    {
        return $this->emailTemplateRepository->updateEmailTemplateStatus($data);
    }

    public function find($id)
    {
        return $this->emailTemplateRepository->find($id);
    }
}
