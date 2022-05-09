<?php

namespace Modules\FrontendCMS\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\FrontendCMS\Repositories\FeatureRepository;

class FeatureService{

    protected $featureRepository;

    public function __construct(FeatureRepository  $featureRepository)
    {
        $this->featureRepository = $featureRepository;
    }

    public function save($data)
    {
        return $this->featureRepository->save($data);
    }

    public function update($data,$id)
    {
        return $this->featureRepository->update($data, $id);
    }

    public function getAll()
    {
        return $this->featureRepository->getAll();
    }
    public function getActiveAll(){
        return $this->featureRepository->getActiveAll();
    }

    public function deleteById($id)
    {
        return $this->featureRepository->delete($id);
    }

    public function showById($id)
    {
        return $this->featureRepository->show($id);
    }

    public function editById($id){
        return $this->featureRepository->edit($id);
    }

}
