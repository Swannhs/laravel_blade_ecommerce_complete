<?php

namespace Modules\Review\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Review\Repositories\SellerReviewRepository;

class SellerReviewService{

    protected $sellerReviewRepository;

    public function __construct(SellerReviewRepository $sellerReviewRepository)
    {
        $this->sellerReviewRepository = $sellerReviewRepository;
    }

    public function getAll()
    {
        return $this->sellerReviewRepository->getAll();
    }
    public function getPendingAll(){
        return $this->sellerReviewRepository->getPendingAll();
    }
    public function getDeclinedAll(){
        return $this->sellerReviewRepository->getDeclinedAll();
    }
    public function approve($id){
        return $this->sellerReviewRepository->approve($id);
    }
    public function approveALl(){
        return $this->sellerReviewRepository->approveAll();
    }
    public function deleteById($id){
        return $this->sellerReviewRepository->deleteById($id);
    }

}
