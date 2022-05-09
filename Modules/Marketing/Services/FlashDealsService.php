<?php

namespace Modules\Marketing\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Marketing\Repositories\FlashDealsRepository;
use App\Traits\ImageStore;
use Modules\Marketing\Entities\FlashDeal;

class FlashDealsService{
    use ImageStore;
    
    protected $flashDealsRepository;

    public function __construct(FlashDealsRepository $flashDealsRepository)
    {
        $this->flashDealsRepository = $flashDealsRepository;
    }

    public function getAll(){
        return $this->flashDealsRepository->getAll();
    }

    public function store($data){
        if(isset($data['banner_image'])){
            $imagename = ImageStore::saveImage($data['banner_image'],500,1920);
        }
        $data['banner_image'] = $imagename;

        return $this->flashDealsRepository->store($data);
    }

    public function update($data, $id){
        $flash_deal = FlashDeal::findOrFail($id);
        if(isset($data['banner_image'])){
            ImageStore::deleteImage($flash_deal->banner_image);
            $imagename = ImageStore::saveImage($data['banner_image'],500,1920);
            $data['banner_image'] = $imagename;
        }else{
            $data['banner_image'] = $flash_deal->banner_image;
        }
        return $this->flashDealsRepository->update($data, $id);

    }

    public function statusChange($data){
        return $this->flashDealsRepository->statusChange($data);
    }
    public function featuredChange($data){
        return $this->flashDealsRepository->featuredChange($data);
    }
    public function editById($id){
        return $this->flashDealsRepository->editById($id);
    }
    public function deleteById($id){
        $flash_deal = FlashDeal::findOrFail($id);
        ImageStore::deleteImage($flash_deal->banner_image);
        return $this->flashDealsRepository->deleteById($id);
    }
    public function getSellerProduct(){
        return $this->flashDealsRepository->getSellerProduct();
    }

    public function getActiveFlashDeal(){
        return $this->flashDealsRepository->getActiveFlashDeal();
    }

}
