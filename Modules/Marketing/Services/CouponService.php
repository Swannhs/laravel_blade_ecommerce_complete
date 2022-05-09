<?php

namespace Modules\Marketing\Services;

use \Modules\Marketing\Repositories\CouponRepository;

class CouponService{

    protected $couponRepository;

    public function __construct(CouponRepository $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    public function getAll(){
        return $this->couponRepository->getAll();
    }
    public function getProduct(){
        return $this->couponRepository->getProduct();
    }
    public function store($data){

        return $this->couponRepository->store($data);
    }
    public function update($data){
        return $this->couponRepository->update($data);
    }

    public function deleteById($id){
        return $this->couponRepository->deleteById($id);
    }
    public function editById($id){
        return $this->couponRepository->editById($id);
    }

}
