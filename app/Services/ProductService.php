<?php
namespace App\Services;

use App\Repositories\ProductRepository;


class ProductService{

    protected $productRepository;

    public function __construct(ProductRepository $productRepository){
        $this->productRepository = $productRepository;
    }

    public function getProductBySlug($slug)
    {
        return $this->productRepository->getProductBySlug($slug);
    }

    public function getActiveSellerProductBySlug($slug)
    {
        return $this->productRepository->getActiveSellerProductBySlug($slug);
    }

    public function getProductByID($id){
        return $this->productRepository->getProductByID($id);
    }

    public function recentViewIncrease($id){
        return $this->productRepository->recentViewIncrease($id);
    }

    public function recentViewStore($seller_product_id)
    {
        return $this->productRepository->recentViewStore($seller_product_id);
    }

    public function lastRecentViewinfo()
    {
        return $this->productRepository->lastRecentViewinfo();
    }

    public function getReviewByPage($data){
        return $this->productRepository->getReviewByPage($data);
    }

}
