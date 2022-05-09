<?php
namespace App\Services;

use App\Repositories\AuthRepository;


class AuthService{

    protected $authRepository;

    public function __construct(AuthRepository $authRepository){
        $this->authRepository = $authRepository;
    }

    public function register($data){
        return $this->authRepository->register($data);
    }

    public function changePassword($user = null, $data){
        return $this->authRepository->changePassword($user, $data);
    }



}