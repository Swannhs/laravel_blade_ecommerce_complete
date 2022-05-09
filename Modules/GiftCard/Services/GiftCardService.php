<?php

namespace Modules\GiftCard\Services;

use Illuminate\Support\Facades\Validator;
use Modules\GiftCard\Repositories\GiftCardRepository;

class GiftCardService
{
    protected $giftcardRepository;

    public function __construct(GiftCardRepository  $giftcardRepository)
    {
        $this->giftcardRepository= $giftcardRepository;
    }

    public function getAll(){
        return $this->giftcardRepository->getAll();
    }

    public function store($data){
        return $this->giftcardRepository->store($data);
    }

    public function statusChange($data){
        return $this->giftcardRepository->statusChange($data);
    }

    public function getById($id){
        return $this->giftcardRepository->getById($id);
    }

    public function update($data, $id){
        return $this->giftcardRepository->update($data, $id);
    }

    public function deleteById($id){
        return $this->giftcardRepository->deleteById($id);
    }

    public function getShipping(){
        return $this->giftcardRepository->getShipping();
    }
    public function send_code_to_mail($data)
    {
        return $this->giftcardRepository->send_code_to_mail($data);
    }

    public function csvUploadCategory($data)
    {
        return $this->giftcardRepository->csvUploadCategory($data);
    }

}
