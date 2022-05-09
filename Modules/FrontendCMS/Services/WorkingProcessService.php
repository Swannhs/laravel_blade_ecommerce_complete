<?php

namespace Modules\FrontendCMS\Services;


use App\Traits\ImageStore;
use \Modules\FrontendCMS\Repositories\WorkingProcessRepository;

class WorkingProcessService
{
    use ImageStore;

    protected $workingProcessRepository;

    public function __construct(WorkingProcessRepository $workingProcessRepository)
    {
        $this->workingProcessRepository = $workingProcessRepository;
    }

    public function save($data)
    {
        if(isset($data['image'])){
            $imageName = ImageStore::saveImage($data['image'],60,60);

        }else{
            $imageName = null;
        }
        $data['image'] = $imageName;

        return $this->workingProcessRepository->save($data);
    }

    public function update($data, $id)
    {

        $getData = $this->workingProcessRepository->edit($id);
        if (isset($data['image'])) {
            ImageStore::deleteImage($getData->image);
            $imageName = ImageStore::saveImage($data['image'],60,60);
            $newData = [
                'title' => $data['title'],
                'position' => $data['position'],
                'image' => $imageName,
                'status' => $data['status'],
                'description' => $data['description']
            ];
        } else {
            $newData = [
                'title' => $data['title'],
                'position' => $data['position'],
                'image' => $getData->image,
                'status' => $data['status'],
                'description' => $data['description']
            ];
        }



        return $this->workingProcessRepository->update($newData, $id);
    }

    public function getAll()
    {
        return $this->workingProcessRepository->getAll();
    }
    public function getAllActive(){
        return $this->workingProcessRepository->getAllActive();
    }

    public function deleteById($id)
    {
        $getData = $this->workingProcessRepository->edit($id);
        ImageStore::deleteImage($getData->image);
        return $this->workingProcessRepository->delete($id);
    }

    public function editById($id)
    {
        return $this->workingProcessRepository->edit($id);
    }
}
