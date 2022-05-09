<?php
namespace App\Services;

use App\Repositories\SubscriptionRepository;


class SubscriptionService{

    protected $subscribe;

    public function __construct(SubscriptionRepository $subscribe){
        $this->subscribe = $subscribe;
    }

    public function store($data){
        return $this->subscribe->store($data);
    }
}