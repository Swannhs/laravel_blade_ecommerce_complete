<?php
namespace App\Services;

use App\Repositories\FlashDealRepository;


class FlashDealService{

    protected $flashDealRepository;

    public function __construct(FlashDealRepository $flashDealRepository){
        $this->flashDealRepository = $flashDealRepository;
    }
    
    public function getById($slug){
        return $this->flashDealRepository->getById($slug);
    }
    public function getFlashProducts($id){
        return $this->flashDealRepository->getFlashProducts($id);
    }

}