<?php

namespace Modules\SupportTicket\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\SupportTicket\Repositories\TicketPriorityRepository;

class TicketPriorityService
{
    protected $ticketPriorityRepository;

    public function __construct(TicketPriorityRepository  $ticketPriorityRepository)
    {
        $this->ticketPriorityRepository= $ticketPriorityRepository;
    }

    public function getAll()
    {
        return $this->ticketPriorityRepository->getAll();
    }
    public function getActiveAll(){
        return $this->ticketPriorityRepository->getActiveAll();
    }

    public function create(array $data)
    {
        return $this->ticketPriorityRepository->create($data);
    }

    public function find($id)
    {   

        return $this->ticketPriorityRepository->find($id);
       
    }

    public function update(array $data)
    {
        return $this->ticketPriorityRepository->update($data);
    }
    public function statusChange($data){
        return $this->ticketPriorityRepository->statusChange($data);
    }

    public function delete($id)
    {
        return $this->ticketPriorityRepository->delete($id);
    }

}
