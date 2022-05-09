<?php
namespace Modules\Marketing\Repositories;

use Modules\Marketing\Entities\ReferralCode;
use Modules\Marketing\Entities\ReferralCodeSetup;

class ReferralCodeRepository {

    public function getAll(){
        return ReferralCode::latest();
    }
    public function getSetup(){
        return ReferralCodeSetup::first();
    }
    public function updateSetup($data){
        return ReferralCodeSetup::findOrFail($data['id'])->update([
            'amount' => $data['amount'],
            'maximum_limit' => $data['maximum_limit'],
            'status' => $data['status']
        ]);
    }
    public function statusChange($data){
        return ReferralCode::findOrFail($data['id'])->update([
            'status' => $data['status']
        ]);
    }
}
