<?php
namespace App\Services;

use App\Repositories\SupportTicketRepository;

class SupportTicketService
{
    protected $supportTicketRepository;

    public function __construct(SupportTicketRepository $supportTicketRepository)
    {
        $this->supportTicketRepository = $supportTicketRepository;
    }

    public function getMyTickets($id){
        return $this->supportTicketRepository->getMyTickets($id);
    }

    public function getMyTicketWithPaginate($data){
        return $this->supportTicketRepository->getMyTicketWithPaginate($data);
    }

    public function getCategories(){
        return $this->supportTicketRepository->getCategories();
    }

    public function getPriorities(){
        return $this->supportTicketRepository->getPriorities();
    }

    public function getStatuses(){
        return $this->supportTicketRepository->getStatuses();
    }

    public function store($data, $user_id){
        return $this->supportTicketRepository->store($data, $user_id);
    }
    
    public function getTicketById($id){
        return $this->supportTicketRepository->getTicketById($id);
    }
}
