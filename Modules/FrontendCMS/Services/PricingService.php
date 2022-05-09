<?php

namespace Modules\FrontendCMS\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\FrontendCMS\Repositories\PricingRepository;

class PricingService{

    protected $pricingRepository;

    public function __construct(PricingRepository  $pricingRepository)
    {
        $this->pricingRepository = $pricingRepository;
    }

    public function save($data)
    {
        return $this->pricingRepository->save($data);
    }

    public function update($data,$id)
    {
        return $this->pricingRepository->update($data, $id);
    }

    public function getAll()
    {
        return $this->pricingRepository->getAll();
    }

    public function getAllActive()
    {
        return $this->pricingRepository->getAllActive();
    }

    public function deleteById($id)
    {
        return $this->pricingRepository->delete($id);
    }

    public function showById($id)
    {
        return $this->pricingRepository->show($id);
    }

    public function editById($id){
        return $this->pricingRepository->edit($id);
    }
    public function statusUpdate($data, $id){
        return $this->pricingRepository->statusUpdate($data, $id);
    }

}
