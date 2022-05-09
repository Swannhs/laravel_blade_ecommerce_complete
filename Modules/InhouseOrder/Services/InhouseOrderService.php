<?php
namespace Modules\InhouseOrder\Services;

use Illuminate\Support\Arr;
use Modules\InhouseOrder\Repositories\InhouseOrderRepository;

class InhouseOrderService
{
    protected $inhouseOrderRepository;

    public function __construct(InhouseOrderRepository $inhouseOrderRepository){
        $this->inhouseOrderRepository = $inhouseOrderRepository;
    }

    public function getProducts(){
        return $this->inhouseOrderRepository->getProducts();
    }

    public function getCountries(){
        return $this->inhouseOrderRepository->getCountries();
    }

    public function getVariantByProduct($id){
        return $this->inhouseOrderRepository->getVariantByProduct($id);
    }

    public function productTypeCheck($id){
        return $this->inhouseOrderRepository->productTypeCheck($id);
    }

    public function addToCart($id){
        return $this->inhouseOrderRepository->addToCart($id);
    }

    public function storeVariantProductToCart($id){
        return $this->inhouseOrderRepository->storeVariantProductToCart($id);
    }

    public function getInhouseCartData(){
        return $this->inhouseOrderRepository->getInhouseCartData();
    }

    public function changeShippingMethod($data){
        return $this->inhouseOrderRepository->changeShippingMethod($data);
    }

    public function changeQty($data){
        return $this->inhouseOrderRepository->changeQty($data);
    }

    public function getPaymentMethods(){
        return $this->inhouseOrderRepository->getPaymentMethods();
    }

    public function deleteById($id){
        return $this->inhouseOrderRepository->deleteById($id);
    }

    public function addressSave($data){
        return $this->inhouseOrderRepository->addressSave($data);
    }

    public function resetAddress(){
        return $this->inhouseOrderRepository->resetAddress();
    }

    public function store($data){
        return $this->inhouseOrderRepository->store($data);
    }

    public function inhouseOrderList(){
        return $this->inhouseOrderRepository->inhouseOrderList();
    }
    
}
