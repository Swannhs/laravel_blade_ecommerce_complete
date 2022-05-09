<?php

namespace Modules\Review\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Review\Repositories\ProductReviewRepository;

class ProductReviewService{

    protected $productReviewRepository;

    public function __construct(ProductReviewRepository $productReviewRepository)
    {
        $this->productReviewRepository = $productReviewRepository;
    }

    public function getAll()
    {
        return $this->productReviewRepository->getAll();
    }

    public function getPendingAll(){
        return $this->productReviewRepository->getPendingAll();
    }
    public function getDeclinedAll(){
        return $this->productReviewRepository->getDeclinedAll();
    }

    public function approve($id){
        return $this->productReviewRepository->approve($id);
    }
    public function approveALl(){
        return $this->productReviewRepository->approveAll();
    }
    public function deleteById($id){
        return $this->productReviewRepository->deleteById($id);
    }

     public function getReviewConfiguration()
    {
        return $this->productReviewRepository->getReviewConfiguration();
    }


    public function reviewConfigurationUpdate($request)
    {
        return $this->productReviewRepository->reviewConfigurationUpdate($request);
    }


}
