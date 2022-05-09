<?php

namespace Modules\Marketing\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Marketing\Repositories\NewUserZoneRepository;
use App\Traits\ImageStore;
use Modules\Marketing\Entities\NewUserZone;

class NewUserZoneService{
    use ImageStore;

    protected $newUserZoneRepository;

    public function __construct(NewUserZoneRepository $newUserZoneRepository)
    {
        $this->newUserZoneRepository = $newUserZoneRepository;
    }

    public function getAll(){
        return $this->newUserZoneRepository->getAll();
    }

    public function store($data){
        if(isset($data['banner_image'])){
            $imagename = ImageStore::saveImage($data['banner_image'],500,1920);
        }else{
            $imagename = NULL;
        }
        $data['banner_image'] = $imagename;

        return $this->newUserZoneRepository->store($data);
    }

    public function update($data, $id){
        $flash_deal = NewUserZone::findOrFail($id);
        if(isset($data['banner_image'])){
            ImageStore::deleteImage($flash_deal->banner_image);
            $imagename = ImageStore::saveImage($data['banner_image'],500,1920);
            $data['banner_image'] = $imagename;
        }else{
            $data['banner_image'] = $flash_deal->banner_image;
        }
        return $this->newUserZoneRepository->update($data, $id);

    }

    public function statusChange($data){
        return $this->newUserZoneRepository->statusChange($data);
    }
    public function featuredChange($data){
        return $this->newUserZoneRepository->featuredChange($data);
    }
    public function editById($id){
        return $this->newUserZoneRepository->editById($id);
    }
    public function deleteById($id){
        $flash_deal = NewUserZone::findOrFail($id);
        ImageStore::deleteImage($flash_deal->banner_image);
        return $this->newUserZoneRepository->deleteById($id);
    }
    public function getSellerProduct(){
        return $this->newUserZoneRepository->getSellerProduct();
    }
    public function getCategories(){
        return $this->newUserZoneRepository->getCategories();
    }
    public function getCoupons(){
        return $this->newUserZoneRepository->getCoupons();
    }

    public function getActiveNewUserZone(){
        return $this->newUserZoneRepository->getActiveNewUserZone();
    }
    public function getAllCategory(){
        return $this->newUserZoneRepository->getAllCategory();
    }
}
