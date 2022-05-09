<?php
namespace Modules\Shipping\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Shipping\Repositories\ShippingRepository;
use App\Traits\ImageStore;
use Illuminate\Support\Arr;
use Modules\Shipping\Entities\ShippingMethod;

class ShippingService
{
    protected $shippingRepository;

    public function __construct(ShippingRepository  $shippingRepository)
    {
        $this->shippingRepository = $shippingRepository;
    }

    public function getAll()
    {
        return $this->shippingRepository->getAll();
    }

    public function getRequestedSellerOwnShippingMethod()
    {
        return $this->shippingRepository->getRequestedSellerOwnShippingMethod();
    }

    public function getActiveAll()
    {
        return $this->shippingRepository->getActiveAll();
    }

    public function store($data)
    {
        if (!empty($data['method_logo'])) {
            $data = Arr::add($data, 'logo', ImageStore::saveImage($data['method_logo'],150,150));
        }

        if (auth()->user()->role->type == 'seller') {
            $data['request_by_user'] = auth()->user()->id;
            $data['is_approved'] = 0;
            $data['is_active'] = 0;
        }
        return $this->shippingRepository->store($data);
    }

    public function findById($id)
    {
        return $this->shippingRepository->find($id);
    }

    public function update($data, $id)
    {
        $shipping = ShippingMethod::find($id);
        if (!empty($data['method_logo'])) {
            $data = Arr::add($data, 'logo', ImageStore::saveImage($data['method_logo'],150,150));
            ImageStore::deleteImage($shipping->logo);
        }
        return $this->shippingRepository->update($data, $id);
    }

    public function delete($id)
    {
        $shipping = ShippingMethod::find($id);
        if($shipping){
            ImageStore::deleteImage($shipping->logo);
        }
        return $this->shippingRepository->delete($id);
    }

    public function updateStatus($data)
    {
        return $this->shippingRepository->updateStatus($data);
    }

    public function updateApproveStatus($data)
    {
        return $this->shippingRepository->updateApproveStatus($data);
    }
}
