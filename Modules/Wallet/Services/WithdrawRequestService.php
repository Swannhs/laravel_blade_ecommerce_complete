<?php
namespace Modules\Wallet\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Wallet\Repositories\WithdrawRequestRepository;
use Illuminate\Support\Arr;

class WithdrawRequestService
{
    protected $walletRequestRepository;

    public function __construct(WithdrawRequestRepository  $walletRequestRepository)
    {
        $this->walletRequestRepository = $walletRequestRepository;
    }

    public function getAll()
    {
        return $this->walletRequestRepository->getAll();
    }

    public function getMyAll()
    {
        return $this->walletRequestRepository->getMyAll();
    }

    public function findWidrawRequestById($id){
        return $this->walletRequestRepository->findWidrawRequestById($id);
    }

    public function withdrawRequestStore($data)
    {
        return $this->walletRequestRepository->withdrawRequestStore($data);
    }

    public function withdrawRequestUpdate($data)
    {
        return $this->walletRequestRepository->withdrawRequestUpdate($data);
    }

    public function withdrawRequestStatusUpdate($data, $id)
    {
        return $this->walletRequestRepository->withdrawRequestStatusUpdate($data, $id);
    }

    public function delete($id)
    {
        //
    }
}
