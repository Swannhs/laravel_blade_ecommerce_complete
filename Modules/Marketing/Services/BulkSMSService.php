<?php

namespace Modules\Marketing\Services;

use \Modules\Marketing\Repositories\BulkSMSRepository;

class BulkSMSService{
    
    protected $bulkSMSRepository;

    public function __construct(BulkSMSRepository $bulkSMSRepository)
    {
        $this->bulkSMSRepository = $bulkSMSRepository;
    }

    public function getAll(){
        return $this->bulkSMSRepository->getAll();
    }

    public function store($data){
        return $this->bulkSMSRepository->store($data);
    }
    public function update($data){
        return $this->bulkSMSRepository->update($data);
    }

    public function getAllUser(){
        return $this->bulkSMSRepository->getAllUser();
    }
    public function getUserByRole($id){
        return $this->bulkSMSRepository->getUserByRole($id);
    }
    public function deleteById($id){
        return $this->bulkSMSRepository->deleteById($id);
    }
    public function editById($id){
        return $this->bulkSMSRepository->editById($id);
    }
    public function testSMS($data){
        return $this->bulkSMSRepository->testSMS($data);
    }

    public function getActiveTemplate(){
        return $this->bulkSMSRepository->getActiveTemplate();
    }

}
