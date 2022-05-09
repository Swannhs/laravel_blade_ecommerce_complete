<?php
namespace Modules\GeneralSetting\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\GeneralSetting\Repositories\GeneralSettingRepository;
use Illuminate\Support\Arr;

class GeneralSettingService
{
    protected $generalSettingRepository;

    public function __construct(GeneralSettingRepository  $generalSettingRepository)
    {
        $this->generalSettingRepository = $generalSettingRepository;
    }

    public function getAll()
    {
        return $this->generalSettingRepository->all();
    }

    public function getVerificationNotification()
    {
        return $this->generalSettingRepository->getVerificationNotificationAll();
    }

    public function getVendorConfigurationAll()
    {
        return $this->generalSettingRepository->getVendorConfigurationAll();
    }

    public function getSmsGateways()
    {
        return $this->generalSettingRepository->getSmsGatewaysAll();
    }

    public function getLanguages()
    {
        return $this->generalSettingRepository->getLanguagesAll();
    }

    public function getDateFormats()
    {
        return $this->generalSettingRepository->getDateFormatsAll();
    }

    public function getTimezones()
    {
        return $this->generalSettingRepository->getTimezonesAll();
    }

    public function updateEmailFooterTemplate($data){
        return $this->generalSettingRepository->updateEmailFooterTemplate($data);
    }

    public function getGeneralInfo()
    {
        return $this->generalSettingRepository->getGeneralInfoDetails();
    }

    public function update_activation($data)
    {
        return $this->generalSettingRepository->updateActivationStatus($data);
    }

    public function update_sms_activation($data)
    {
        return $this->generalSettingRepository->updateActivationSmsStatus($data);
    }

    public function update_smtp_gateway_credentials($data)
    {
        if ($data['mail_gateway'] == 'sendmail') {
            $data = Arr::add($data, 'MAIL_MAILER', 'smtp');
        }else {
            $data = Arr::add($data, 'MAIL_MAILER', $data['mail_gateway']);
        }
        return $this->generalSettingRepository->update_smtp_gateway_credential($data);
    }

    public function update($data)
    {
        return $this->generalSettingRepository->update($data);
    }
    public function updateShopLink($shopLinkUrl)
    {
        return $this->generalSettingRepository->updateShopLink($shopLinkUrl);
    }
}
