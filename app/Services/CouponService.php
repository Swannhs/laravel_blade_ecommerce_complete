<?php
namespace App\Services;

use App\Repositories\CouponRepository;


class CouponService{

    protected $couponRepository;

    public function __construct(CouponRepository $couponRepository){
        $this->couponRepository = $couponRepository;
    }
    public function getAll($user_id){
        return $this->couponRepository->getAll($user_id);
    }
    
    public function store($data, $user_id){
        return $this->couponRepository->store($data, $user_id);
    }

    public function deleteById($id, $user_id){
        return $this->couponRepository->deleteById($id, $user_id);
    }

}