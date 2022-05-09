<?php

namespace Modules\Marketing\Services;

use \Modules\Marketing\Repositories\ReferralCodeRepository;

class ReferralCodeService{
    
    protected $referralCodeRepository;

    public function __construct(ReferralCodeRepository $referralCodeRepository)
    {
        $this->referralCodeRepository = $referralCodeRepository;
    }

    public function getAll(){
        return $this->referralCodeRepository->getAll();
    }
    public function getSetup(){
        return $this->referralCodeRepository->getSetup();
    }
    public function updateSetup($data){
        return $this->referralCodeRepository->updateSetup($data);
    }
    public function statusChange($data){
        return $this->referralCodeRepository->statusChange($data);
    }

}
