<?php

namespace Modules\FrontendCMS\Services;

use \Modules\FrontendCMS\Repositories\MerchantContentRepository;

class MerchantContentService
{

    protected $merchantContentRepository;

    public function __construct(MerchantContentRepository  $merchantContentRepository)
    {
        $this->merchantContentRepository = $merchantContentRepository;
    }


    public function getAll(){
        return $this->merchantContentRepository->getAll();
    }

    public function update($data, $id)
    {
        return $this->merchantContentRepository->update($data, $id);
    }

    public function editById($id)
    {
        return $this->merchantContentRepository->edit($id);
    }
}
