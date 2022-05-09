<?php

namespace Modules\Seller\Services;

use Illuminate\Support\Facades\Validator;
use Modules\Seller\Repositories\ProductRepository;
use App\Traits\ImageStore;

class ProductService
{
    use ImageStore;
    protected $productRepository;

    public function __construct(ProductRepository $productRepository){
        $this->productRepository = $productRepository;
    }

    public function getAll(){
        return $this->productRepository->getAll();
    }

    public function getAllSellerProduct(){
        return $this->productRepository->getAllSellerProduct();
    }

    public function getRecomandedProduct(){
        return $this->productRepository->getRecomandedProduct();
    }

    public function getTopPicks(){
        return $this->productRepository->getTopPicks();
    }

    public function getSellerProductById($id){
        return $this->productRepository->getSellerProductById($id);
    }

    public function getFilterdProduct($data){
        return $this->productRepository->getFilterdProduct($data);
    }

    public function getMyProducts(){
        return $this->productRepository->getMyProducts();
    }

    public function getAllProduct(){
        return $this->productRepository->getAllProduct();
    }
    public function getProductOfOtherSeller(){
        return $this->productRepository->getProductOfOtherSeller();
    }

    public function getProduct($id){
        return $this->productRepository->getProduct($id);
    }

    public function stockManageStatus($data){
        return $this->productRepository->stockManageStatus($data);
    }

    public function store($data){
        if(isset($data['thumbnail_image'])){
            $thumbnail_image = ImageStore::saveImage($data['thumbnail_image'], 165, 165);
            $data['thum_img_src'] = $thumbnail_image;
        }

        return $this->productRepository->store($data);
    }

    public function findById($id){
        return $this->productRepository->findById($id);
    }

    public function findBySellerProductId($id){
        return $this->productRepository->findBySellerProductId($id);
    }

    public function deleteById($id){
        return $this->productRepository->deleteById($id);
    }

    public function update($data, $id){

        if(isset($data['thumbnail_image'])){
            $product = $this->getSellerProductById($id);
            if($product->thum_img != null){
                ImageStore::deleteImage($product->thum_img);
                $data['thum_img_src'] = ImageStore::saveImage($data['thumbnail_image'], 165, 165);
            }
        }

        return $this->productRepository->update($data, $id);
    }

    public function statusChange($data, $id){
        return $this->productRepository->statusChange($data, $id);
    }
    public function getVariantByProduct($data)
    {
        return $this->productRepository->getVariantByProduct($data);
    }

    public function getThisSKUProduct($id){
        return $this->productRepository->getThisSKUProduct($id);
    }

    public function variantDelete($id){
        return $this->productRepository->variantDelete($id);
    }

    public function getSellerBusinessInfo(){
        return $this->productRepository->getSellerBusinessInfo();
    }

    public function getSellerBankInfo(){
        return $this->productRepository->getSellerBankInfo();
    }

    public function get_seller_product_sku_wise_price($data){
        
        return $this->productRepository->get_seller_product_sku_wise_price($data);
    }

}
