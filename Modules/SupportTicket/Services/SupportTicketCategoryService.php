<?php

namespace Modules\SupportTicket\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\SupportTicket\Repositories\SupportTicketCategoryRepository;

class SupportTicketCategoryService
{
    protected $supportTicketCategoryRepository;

    public function __construct(SupportTicketCategoryRepository  $supportTicketCategoryRepository)
    {
        $this->supportTicketCategoryRepository= $supportTicketCategoryRepository;
    }

    public function getAll()
    {
        return $this->supportTicketCategoryRepository->getAll();
    }
    public function getActiveAll(){
        return $this->supportTicketCategoryRepository->getActiveAll();
    }

    public function create(array $data)
    {
        return $this->supportTicketCategoryRepository->create($data);
    }

    public function find($id)
    {   

        return $this->supportTicketCategoryRepository->find($id);
       
    }

    public function update(array $data)
    {
        return $this->supportTicketCategoryRepository->update($data);
    }

    public function statusChange($data){
        return $this->supportTicketCategoryRepository->statusChange($data);
    }

    public function delete($id)
    {
        return $this->supportTicketCategoryRepository->delete($id);
    }

}
