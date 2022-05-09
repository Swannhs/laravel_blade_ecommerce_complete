<?php
namespace Modules\GST\Services;

use Illuminate\Support\Facades\Validator;
use Modules\GST\Repositories\GstRepository;
use Illuminate\Support\Arr;

class GSTService
{
    protected $gstRepository;

    public function __construct(GstRepository  $gstRepository)
    {
        $this->gstRepository = $gstRepository;
    }

    public function getAllList()
    {
        return $this->gstRepository->getAllList();
    }

    public function getActiveList()
    {
        return $this->gstRepository->getActiveList();
    }

    public function create($data)
    {
        return $this->gstRepository->create($data);
    }

    public function update($data, $id)
    {
        return $this->gstRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->gstRepository->delete($id);
    }

    public function updateConfiguration($data)
    {
        return $this->gstRepository->updateConfiguration($data);
    }
}
