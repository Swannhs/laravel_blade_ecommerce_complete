<?php
namespace App\Services;

use App\Repositories\CartRepository;


class CartService{

    protected $cartRepository;

    public function __construct(CartRepository $cartRepository){
        $this->cartRepository = $cartRepository;
    }

    public function store($data){
        return $this->cartRepository->store($data);
    }
    public function update($data){
        return $this->cartRepository->update($data);
    }

    public function updateCartShippingInfo($data)
    {
        return $this->cartRepository->updateCartShippingInfo($data);
    }

    public function getCartData(){
        return $this->cartRepository->getCartData();
    }
    public function updateQty($data){
        return $this->cartRepository->updateQty($data);
    }
    public function selectAll($data){
        return $this->cartRepository->selectAll($data);
    }
    public function selectAllSeller($data){
        return $this->cartRepository->selectAllSeller($data);
    }
    public function selectItem($data){
        return $this->cartRepository->selectItem($data);
    }
    public function deleteCartProduct($data){
        return $this->cartRepository->deleteCartProduct($data);
    }
    public function deleteAll(){
        return $this->cartRepository->deleteAll();
    }
}
