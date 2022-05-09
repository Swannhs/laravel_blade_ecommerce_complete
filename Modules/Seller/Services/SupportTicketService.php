<?php

namespace Modules\Seller\Services;

use \Modules\Seller\Repositories\SupportTicketRepository;

class SupportTicketService{

    protected $supportTicketRepository;

    public function __construct(SupportTicketRepository $supportTicketRepository)
    {
        $this->supportTicketRepository = $supportTicketRepository;
    }

    public function getTickets(){
        return $this->supportTicketRepository->getTickets();
    }

    public function getBySearch($category_id,$priority_id,$status_id){
        return $this->supportTicketRepository->getBySearch($category_id,$priority_id,$status_id);
    }

    public function categoryList(){
        return $this->supportTicketRepository->categoryList();
    }

    public function priorityList(){
        return $this->supportTicketRepository->priorityList();
    }

    public function statusList(){
        return $this->supportTicketRepository->statusList();
    }
    public function getById($id){
        return $this->supportTicketRepository->getById($id);
    }

    public function store($data){
        return $this->supportTicketRepository->store($data);
    }
    
    public function update($data,$id){
        return $this->supportTicketRepository->update($data, $id);
    }

    public function createMessage($data){
        return $this->supportTicketRepository->createMessage($data);
    }


}
