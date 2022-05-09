<?php

namespace Modules\FrontendCMS\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\FrontendCMS\Repositories\SubcribeContentRepository;

class SubcribeContentService{

    protected $subscribeRepository;

    public function __construct(SubcribeContentRepository  $subscribeRepository)
    {
        $this->subscribeRepository = $subscribeRepository;
    }

    public function update($data, $id)
    {
        return $this->subscribeRepository->update($data, $id);
    }

    public function editById($id)
    {
        return $this->subscribeRepository->edit($id);
    }

}