<?php
namespace Modules\Refund\Services;

use Modules\Refund\Repositories\RefundReasonRepository;
use Illuminate\Support\Arr;

class RefundReasonService
{
    protected $refundRepository;

    public function __construct(RefundReasonRepository $refundRepository){
        $this->refundRepository = $refundRepository;
    }

    public function getAll()
    {
        return $this->refundRepository->getAll();
    }

    public function save($data)
    {
        return $this->refundRepository->save($data);
    }

    public function update($data, $id)
    {
        return $this->refundRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->refundRepository->delete($id);
    }
}
