<?php

namespace Modules\FrontendCMS\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\FrontendCMS\Repositories\AboutUsRepository;
use App\Traits\ImageStore;

class AboutUsService{

    use ImageStore;
    protected $aboutusRepository;

    public function __construct(AboutUsRepository  $aboutusRepository)
    {
        $this->aboutusRepository = $aboutusRepository;
    }

    public function getAll()
    {
        return $this->aboutusRepository->getAll();
    }

    public function update($data,$id)
    {
        $getData = $this->aboutusRepository->edit($id);
        if(!empty($data['sec1_image'] )){
            ImageStore::deleteImage($getData->sec1_image);
            $imagename1 = ImageStore::saveImage($data['sec1_image'],545,600);
            $data['sec1_image']=$imagename1;
        }
        else{
            $data['sec1_image']=$getData['sec1_image'];
        }
        if(!empty($data['sec2_image'] )){
            ImageStore::deleteImage($getData->sec2_image);
            $imagename2 = ImageStore::saveImage($data['sec2_image'],545,600);
            $data['sec2_image']=$imagename2;
        } 
        else{
            $data['sec2_image']=$getData['sec2_image'];
        }
        return $this->aboutusRepository->update($data, $id);
    }

    public function editById($id)
    {
        return $this->aboutusRepository->edit($id);
    }

}
