<?php

namespace Modules\FrontendCMS\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\FrontendCMS\Repositories\ContactContentRepository;

class ContactContentService
{

    protected $contactContentRepository;

    public function __construct(ContactContentRepository  $contactContentRepository)
    {
        $this->contactContentRepository = $contactContentRepository;
    }


    public function getAll(){
        return $this->contactContentRepository->all();
    }

    public function update($data, $id)
    {
        return $this->contactContentRepository->update($data, $id);
    }

    public function editById($id)
    {
        return $this->contactContentRepository->edit($id);
    }
}
