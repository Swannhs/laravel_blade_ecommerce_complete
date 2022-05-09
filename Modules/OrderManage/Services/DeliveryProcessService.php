<?php
namespace Modules\OrderManage\Services;

use Modules\OrderManage\Repositories\DeliveryProcessRepository;
use Illuminate\Support\Arr;

class DeliveryProcessService
{
    protected $deliveryProcessRepository;

    public function __construct(DeliveryProcessRepository $deliveryProcessRepository){
        $this->deliveryProcessRepository = $deliveryProcessRepository;
    }

    public function getAll()
    {
        return $this->deliveryProcessRepository->getAll();
    }

    public function save($data)
    {
        return $this->deliveryProcessRepository->save($data);
    }

    public function update($data, $id)
    {
        return $this->deliveryProcessRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->deliveryProcessRepository->delete($id);
    }
}
