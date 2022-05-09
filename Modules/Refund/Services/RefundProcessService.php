<?php
namespace Modules\Refund\Services;

use Modules\Refund\Repositories\RefundProcessRepository;
use Illuminate\Support\Arr;

class RefundProcessService
{
    protected $refundProcessRepository;

    public function __construct(RefundProcessRepository $refundProcessRepository){
        $this->refundProcessRepository = $refundProcessRepository;
    }

    public function getAll()
    {
        return $this->refundProcessRepository->getAll();
    }

    public function save($data)
    {
        return $this->refundProcessRepository->save($data);
    }

    public function update($data, $id)
    {
        return $this->refundProcessRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->refundProcessRepository->delete($id);
    }
}
