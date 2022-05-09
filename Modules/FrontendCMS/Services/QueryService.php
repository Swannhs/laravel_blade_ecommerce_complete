<?php

namespace Modules\FrontendCMS\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\FrontendCMS\Repositories\QueryRepository;

class QueryService{

    protected $queryRepository;

    public function __construct(QueryRepository  $queryRepository)
    {
        $this->queryRepository = $queryRepository;
    }

    public function save($data)
    {
        return $this->queryRepository->save($data);
    }

    public function update($data,$id)
    {
        return $this->queryRepository->update($data, $id);
    }

    public function getAll()
    {
        return $this->queryRepository->getAll();
    }

    public function getAllActive()
    {
        return $this->queryRepository->getAllActive();
    }

    public function deleteById($id)
    {
        return $this->queryRepository->delete($id);
    }

    public function showById($id)
    {
        return $this->queryRepository->show($id);
    }

    public function editById($id){
        return $this->queryRepository->edit($id);
    }
    public function statusUpdate($data, $id){
        return $this->queryRepository->statusUpdate($data, $id);
    }

}
