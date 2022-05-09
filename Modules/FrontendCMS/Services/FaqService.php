<?php

namespace Modules\FrontendCMS\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\FrontendCMS\Repositories\FaqRepository;

class FaqService
{

    protected $faqRepository;

    public function __construct(FaqRepository  $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    public function save($data)
    {
        return $this->faqRepository->save($data);
    }

    public function update($data, $id)
    {
        return $this->faqRepository->update($data, $id);
    }

    public function getAll()
    {
        return $this->faqRepository->getAll();
    }
    public function getAllActive()
    {
        return $this->faqRepository->getAllActive();
    }

    public function deleteById($id)
    {
        return $this->faqRepository->delete($id);
    }

    public function showById($id)
    {
        return $this->faqRepository->show($id);
    }

    public function editById($id)
    {
        return $this->faqRepository->edit($id);
    }
}
