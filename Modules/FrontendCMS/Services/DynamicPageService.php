<?php

namespace Modules\FrontendCMS\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\FrontendCMS\Repositories\DynamicPageRepository;

class DynamicPageService{

    protected $dynamicPageRepository;

    public function __construct(DynamicPageRepository  $dynamicPageRepository)
    {
        $this->dynamicPageRepository = $dynamicPageRepository;
    }

    public function save($data)
    {
        return $this->dynamicPageRepository->save($data);
    }

    public function update($data,$id)
    {
        return $this->dynamicPageRepository->update($data, $id);
    }

    public function getAll()
    {
        return $this->dynamicPageRepository->getAll();
    }
    public function getActiveAll()
    {
        return $this->dynamicPageRepository->getActiveAll();
    }

    public function deleteById($id)
    {
        return $this->dynamicPageRepository->delete($id);
    }

    public function showById($id)
    {
        return $this->dynamicPageRepository->show($id);
    }

    public function editById($id){
        return $this->dynamicPageRepository->edit($id);
    }

    public function statusUpdate($data, $id){
        return $this->dynamicPageRepository->statusUpdate($data, $id);
    }

}
