<?php
namespace App\Services;

use App\Repositories\NewUserZoneRepository;


class NewUserZoneService{

    protected $newUserZoneRepository;

    public function __construct(NewUserZoneRepository $newUserZoneRepository){
        $this->newUserZoneRepository = $newUserZoneRepository;
    }
    
    public function getById($slug){
        return $this->newUserZoneRepository->getById($slug);
    }

    public function getCategoryById($id){
        return $this->newUserZoneRepository->getCategoryById($id);
    }

    public function getCouponCategoryById($id){
        return $this->newUserZoneRepository->getCouponCategoryById($id);
    }

    public function getSellerProducts(){
        return $this->newUserZoneRepository->getSellerProducts();
    }

    public function getAllProductsForCategories($slug){
        return $this->newUserZoneRepository->getAllProductsForCategories($slug);
    }

    public function getAllProductsForCouponCategories($slug){
        return $this->newUserZoneRepository->getAllProductsForCouponCategories($slug);
    }
    

    public function newUserZoneProducts($id){
        return $this->newUserZoneRepository->newUserZoneProducts($id);
    }

    public function couponStore($data){
        return $this->newUserZoneRepository->couponStore($data);
    }

}