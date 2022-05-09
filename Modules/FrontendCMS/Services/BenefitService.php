<?php

namespace Modules\FrontendCMS\Services;

use \Modules\FrontendCMS\Repositories\BenefitRepository;
use App\Traits\ImageStore;

class BenefitService
{
    use ImageStore;

    protected $benefitRepository;

    public function __construct(BenefitRepository  $benefitRepository)
    {
        $this->benefitRepository = $benefitRepository;
    }

    public function save($data)
    {
        $imageName = ImageStore::saveImage($data['image'],80,60);
        $newData = [
            'title' => $data['title'],
            'image' => $imageName,
            'status' => $data['status'],
            'description' => $data['description']
        ];
        return $this->benefitRepository->save($newData);
    }

    public function update($data, $id)
    {

        $getData = $this->benefitRepository->edit($id);
        if (isset($data['image'])) {
            ImageStore::deleteImage($getData->image);
            $imageName = ImageStore::saveImage($data['image'],80,60);
            $newData = [
                'title' => $data['title'],
                'image' => $imageName,
                'status' => $data['status'],
                'description' => $data['description']
            ];
        } else {
            $newData = [
                'title' => $data['title'],
                'image' => $getData->image,
                'status' => $data['status'],
                'description' => $data['description']
            ];
        }

        return $this->benefitRepository->update($newData, $id);
    }

    public function getAll()
    {
        return $this->benefitRepository->getAll();
    }
    public function getAllActive()
    {
        return $this->benefitRepository->getAllActive();
    }

    public function deleteById($id)
    {
        $getData = $this->benefitRepository->edit($id);
        ImageStore::deleteImage($getData->image);
        return $this->benefitRepository->delete($id);
    }

    public function editById($id)
    {
        return $this->benefitRepository->edit($id);
    }
}
