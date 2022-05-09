<?php
namespace Modules\OrderManage\Services;

use Modules\OrderManage\Repositories\CancelReasonRepository;
use Illuminate\Support\Arr;

class CancelReasonService
{
    protected $cancelReasonRepository;

    public function __construct(CancelReasonRepository $cancelReasonRepository){
        $this->cancelReasonRepository = $cancelReasonRepository;
    }

    public function getAll()
    {
        return $this->cancelReasonRepository->getAll();
    }

    public function save($data)
    {
        return $this->cancelReasonRepository->save($data);
    }

    public function update($data, $id)
    {
        return $this->cancelReasonRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->cancelReasonRepository->delete($id);
    }
}
