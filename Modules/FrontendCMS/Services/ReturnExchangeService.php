<?php

namespace Modules\FrontendCMS\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\FrontendCMS\Repositories\ReturnExchangeRepository;

class ReturnExchangeService{

    protected $returnRepository;

    public function __construct(ReturnExchangeRepository  $returnRepository)
    {
        $this->returnRepository = $returnRepository;
    }

    public function update($data,$id)
    {
        return $this->returnRepository->update($data, $id);
    }

    public function getAll()
    {
        return $this->returnRepository->getAll();
    }


    public function showById($id)
    {
        return $this->returnRepository->show($id);
    }

    public function editById($id){
        return $this->returnRepository->edit($id);
    }

}
