<?php

namespace Modules\Seller\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Seller\Repositories\ProductReviewRepository;

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

    public function getById($id){
        return $this->productReviewRepository->getById($id);
    }
    public function reviewStore($data){
        return $this->productReviewRepository->reviewStore($data);
    }

}
