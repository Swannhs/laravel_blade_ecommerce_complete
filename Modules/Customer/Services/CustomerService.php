<?php

namespace Modules\Customer\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Customer\Repositories\CustomerRepository;

class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepository  $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAll()
    {
        return $this->customerRepository->getAll();
    }

    public function find($id)
    {
        return $this->customerRepository->find($id);
    }

    public function store($data){
        return $this->customerRepository->store($data);
    }

    public function update($data, $id){
        return $this->customerRepository->update($data, $id);
    }

    public function destroy($id){
        return $this->customerRepository->destroy($id);
    }

}
