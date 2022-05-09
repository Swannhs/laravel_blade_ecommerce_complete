<?php
namespace App\Services;

use App\Repositories\GiftCardRepository;

class GiftCardService
{
    protected $giftCardRepository;

    public function __construct(GiftCardRepository $giftCardRepository)
    {
        $this->giftCardRepository = $giftCardRepository;
    }

    public function getAll($sort_by, $paginate){
        return $this->giftCardRepository->getAll($sort_by, $paginate);
    }

    public function getForFrontend($slug){
        return $this->giftCardRepository->getForFrontend($slug);
    }

    public function getReviewByPage($data){
        return $this->giftCardRepository->getReviewByPage($data);
    }

    public function getBySlug($slug){
        return $this->giftCardRepository->getBySlug($slug);
    }

    public function getByFilterByType($data, $sort_by, $paginate){
        return $this->giftCardRepository->getByFilterByType($data, $sort_by, $paginate);
    }

    public function getMaxPrice(){
        return $this->giftCardRepository->getMaxPrice();
    }
    public function getMinPrice(){
        return $this->giftCardRepository->getMinPrice();
    }
    public function myPurchasedGiftCard($user)
    {
        return $this->giftCardRepository->myPurchasedGiftCard($user);
    }

    public function myPurchasedGiftCardAll($user)
    {
        return $this->giftCardRepository->myPurchasedGiftCardAll($user);
    }

    public function myPurchasedGiftCardRedeem($data, $user)
    {
        return $this->giftCardRepository->myPurchasedGiftCardRedeem($data, $user);
    }

    public function myPurchasedGiftCardRedeemToWalletFromWalletRecharge($data, $user)
    {
        return $this->giftCardRepository->myPurchasedGiftCardRedeemToWalletFromWalletRecharge($data, $user);
    }
}
