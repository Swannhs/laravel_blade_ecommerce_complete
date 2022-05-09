<?php
namespace Modules\Wallet\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Wallet\Repositories\WalletRepository;
use Illuminate\Support\Arr;

class WalletService
{
    protected $walletRepository;

    public function __construct(WalletRepository  $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function getAll()
    {
        return $this->walletRepository->getAll();
    }

    public function getAllOfflineRecharge()
    {
        return $this->walletRepository->getAllOfflineRecharge();
    }

    public function getAllUsers()
    {
        return $this->walletRepository->getAllUsers();
    }

    public function getAllRequests()
    {
        return $this->walletRepository->getAllRequests();
    }

    public function findById($id)
    {
        return $this->walletRepository->find($id);
    }

    public function gateways()
    {
        return $this->walletRepository->gateways();
    }

    public function walletRecharge($amount, $method, $response)
    {
        return $this->walletRepository->walletRecharge($amount, $method, $response);
    }

    public function walletOfflineRecharge($data)
    {
        return $this->walletRepository->walletOfflineRecharge($data);
    }

    public function walletOfflineRechargeUpdate($data)
    {
        return $this->walletRepository->walletOfflineRechargeUpdate($data);
    }

    public function cartPaymentData($order_id, $total_amount, $type, $customer_id, $user_type)
    {
        return $this->walletRepository->cartPaymentData($order_id, $total_amount, $type, $customer_id, $user_type);
    }

    public function withdrawRequestStore($data)
    {
        return $this->walletRepository->withdrawRequestStore($data);
    }

    public function update($data, $id)
    {
        //
    }

    public function delete($id)
    {
        //
    }

    public function getWalletConfiguration()
    {
        return $this->walletRepository->getWalletConfiguration();
    }

    
    public function walletConfigurationUpdate($request)
    {
        return $this->walletRepository->walletConfigurationUpdate($request);
    }
}
