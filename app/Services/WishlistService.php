<?php
namespace App\Services;

use App\Repositories\WishlistRepository;

class WishlistService
{
    protected $wishlistRepository;

    public function __construct(WishlistRepository $wishlistRepository)
    {
        $this->wishlistRepository = $wishlistRepository;
    }

    public function myWishlist($user_id)
    {
        return $this->wishlistRepository->myWishlist($user_id);
    }

    public function myWishlistAPI($user_id){
        return $this->wishlistRepository->myWishlistAPI($user_id);
    }

    public function myWishlistWithPaginate($data){
        return $this->wishlistRepository->myWishlistWithPaginate($data);
    }

    public function store($data, $customer)
    {
        return $this->wishlistRepository->store($data, $customer);
    }

    public function remove($id, $user_id)
    {
        return $this->wishlistRepository->remove($id, $user_id);
    }

    public function getCustomerWishlistForAPI($user_id){
        return $this->wishlistRepository->getCustomerWishlistForAPI($user_id);
    }

    public function totalWishlistItem($user_id){
        return $this->wishlistRepository->totalWishlistItem($user_id);
    }
}
