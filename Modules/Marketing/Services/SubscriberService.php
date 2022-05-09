<?php

namespace Modules\Marketing\Services;

use \Modules\Marketing\Repositories\SubscriberRepository;

class SubscriberService{
    
    protected $subscriberRepository;

    public function __construct(SubscriberRepository $subscriberRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
    }

    public function getAll(){
        return $this->subscriberRepository->getAll();
    }

    public function deleteById($id){
        return $this->subscriberRepository->deleteById($id);
    }
    public function statusChange($data){
        return $this->subscriberRepository->statusChange($data);
    }

}
