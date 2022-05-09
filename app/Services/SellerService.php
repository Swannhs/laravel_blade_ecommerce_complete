<?php
namespace App\Services;

use App\Repositories\SellerRepository;


class SellerService{

    protected $sellerRepository;

    public function __construct(SellerRepository $sellerRepository){
        $this->sellerRepository = $sellerRepository;
    }

    public function getBySellerID($id)
    {
        return $this->sellerRepository->getBySellerID($id);
    }

    public function getBySellerSlug($slug)
    {
        return $this->sellerRepository->getBySellerSlug($slug);
    }

    public function getProduct($seller_id,$sort_by,$paginate)
    {
        return $this->sellerRepository->getProduct($seller_id,$sort_by,$paginate);
    }

    public function getCategoryList($seller_id)
    {
        return $this->sellerRepository->getCategoryList($seller_id);
    }

    public function getBrandList($seller_id)
    {
        return $this->sellerRepository->getBrandList($seller_id);
    }

    public function getProductLowestPrice($seller_id)
    {
        return $this->sellerRepository->getProductLowestPrice($seller_id);
    }

    public function getProductHighestPrice($seller_id){
        return $this->sellerRepository->getProductHighestPrice($seller_id);
    }

    public function filterProductBlade(array $data, $sort_by, $paginate_by, $seller_id)
    {
        return $this->sellerRepository->filterProductBlade($data, $sort_by, $paginate_by, $seller_id);
    }

    public function filterSortProductBlade(array $data, $session_data, $seller_id)
    {
        return $this->sellerRepository->filterSortProductBlade($data, $session_data, $seller_id);
    }

}
