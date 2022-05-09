<?php

namespace Modules\SupportTicket\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\SupportTicket\Repositories\TicketStatusRepository;

class TicketStatusService
{
    protected $ticketStatusRepository;

    public function __construct(TicketStatusRepository  $ticketStatusRepository)
    {
        $this->ticketStatusRepository= $ticketStatusRepository;
    }

    public function getAll()
    {
        return $this->ticketStatusRepository->getAll();
    }
    public function getActiveAll(){
        return $this->ticketStatusRepository->getActiveAll();
    }

    public function create(array $data)
    {
        return $this->ticketStatusRepository->create($data);
    }

    public function find($id)
    {   

        return $this->ticketStatusRepository->find($id);
       
    }

    public function update(array $data)
    {
        return $this->ticketStatusRepository->update($data);
    }

    public function statusChange($data){
        return $this->ticketStatusRepository->statusChange($data);
    }

    public function delete($id)
    {
        return $this->ticketStatusRepository->delete($id);
    }

}
