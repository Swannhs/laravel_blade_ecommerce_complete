<?php
namespace App\Services;

use App\Repositories\CompareRepository;

class CompareService
{
    protected $compareRepository;

    public function __construct(CompareRepository $compareRepository)
    {
        $this->compareRepository = $compareRepository;
    }

    public function getProduct($user_id){
        return $this->compareRepository->getProduct($user_id);
    }

    public function store($data, $user_id){

        return $this->compareRepository->store($data, $user_id);
    }

    public function removeItem($id, $user_id){
        return $this->compareRepository->removeItem($id, $user_id);
    }

    public function reset($user_id){
        return $this->compareRepository->reset($user_id);
    }

    public function totalCompareItem($user_id){
        return $this->compareRepository->totalCompareItem($user_id);
    }
    
}
