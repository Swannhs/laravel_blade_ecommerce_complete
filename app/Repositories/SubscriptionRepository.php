<?php
namespace App\Repositories;

use App\Models\Subscription;

class SubscriptionRepository{

    protected $subscribe;

    public function __construct(Subscription $subscribe){
        $this->subscribe = $subscribe;
    }

    public function store($data){
        return $this->subscribe::create([
            'email' => $data['email'],
            'status' => 1
        ]);
    }
}