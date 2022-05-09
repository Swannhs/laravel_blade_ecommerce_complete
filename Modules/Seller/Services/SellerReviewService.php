<?php

namespace Modules\Seller\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Seller\Repositories\SellerReviewRepository;

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

}
