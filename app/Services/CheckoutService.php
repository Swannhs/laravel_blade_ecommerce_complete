<?php
namespace App\Services;

use App\Repositories\CheckoutRepository;


class CheckoutService{

    protected $checkoutRepository;

    public function __construct(CheckoutRepository $checkoutRepository){
        $this->checkoutRepository = $checkoutRepository;
    }

    public function getCartItem(){
        return $this->checkoutRepository->getCartItem();
    }

    public function deleteProduct($data){
        return $this->checkoutRepository->deleteProduct($data);
    }
    public function addressStore($data){
        return $this->checkoutRepository->addressStore($data);
    }
    public function addressUpdate($data){
        return $this->checkoutRepository->addressUpdate($data);
    }

    public function guestAddressStore($data)
    {
        return $this->checkoutRepository->guestAddressStore($data);
    }
    public function billingAddressStore($data){
        return $this->checkoutRepository->billingAddressStore($data);
    }

    public function shippingAddressChange($data){
        return $this->checkoutRepository->shippingAddressChange($data);
    }
    public function subscribeFromCheckout($email){
        return $this->checkoutRepository->subscribeFromCheckout($email);
    }

    public function get_active_shipping_methods(){
        return $this->checkoutRepository->get_active_shipping_methods();
    }
    public function activeShippingAddress(){
        return $this->checkoutRepository->activeShippingAddress();
    }

    public function activeBillingAddress(){
        return $this->checkoutRepository->activeBillingAddress();
    }

    public function selectedShippingMethod($id){
        return $this->checkoutRepository->selectedShippingMethod($id);
    }

    public function getCountries(){
        return $this->checkoutRepository->getCountries();
    }


    public function totalAmountForPayment($cartData, $shipping, $address){
        return $this->checkoutRepository->totalAmountForPayment($cartData, $shipping, $address);
    }
    public function getActivePaymentGetways(){
        return $this->checkoutRepository->getActivePaymentGetways();
    }
}
