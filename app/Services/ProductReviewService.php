<?php
namespace App\Services;

use App\Repositories\ProductReviewRepository;


class ProductReviewService{
    protected $productReviewRepository;

    public function __construct(ProductReviewRepository $productReviewRepository){
        $this->productReviewRepository = $productReviewRepository;
    }

    public function store($data, $user = null){

        return $this->productReviewRepository->store($data, $user);
    }

    public function waitingForReview($user){
        return $this->productReviewRepository->waitingForReview($user);
    }

    public function reviewList($user_id){
        return $this->productReviewRepository->reviewList($user_id);
    }

}