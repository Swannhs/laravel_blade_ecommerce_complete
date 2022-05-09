<?php

namespace Modules\Shipping\Repositories;
use Modules\Shipping\Entities\ShippingMethod;

class ShippingRepository
{
    public function getAll()
    {
        return ShippingMethod::get();
    }

    public function getRequestedSellerOwnShippingMethod()
    {
        return ShippingMethod::where('request_by_user', auth()->user()->id)->where('is_approved', 0)->latest()->get();
    }

    public function getActiveAll()
    {
        return ShippingMethod::where('is_active', 1)->get();
    }

    public function store(array $data)
    {
        ShippingMethod::create($data);
    }

    public function find($id)
    {
        return ShippingMethod::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        ShippingMethod::find($id)->update($data);
    }

    public function delete($id)
    {
        $shipping = ShippingMethod::find($id);
        
        if(count($shipping->methodUse) > 0){
            return 'not_possible';
        }
        $shipping->delete();
        return 'possible';

    }

    public function updateStatus(array $data)
    {
        $shipping_method = $this->find($data['id']);
        $shipping_method->is_active = $data['status'];
        $shipping_method->save();
    }

    public function updateApproveStatus($data)
    {
        $shipping_method = $this->find($data['id']);
        $shipping_method->is_approved = $data['status'];
        $shipping_method->save();
    }
}
