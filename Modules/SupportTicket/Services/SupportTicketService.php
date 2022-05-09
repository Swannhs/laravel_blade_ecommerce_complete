<?php

namespace Modules\SupportTicket\Services;

use Illuminate\Support\Facades\Validator;
use Modules\SupportTicket\Repositories\SupportTicketRepository;


class SupportTicketService
{
    protected $supportTicketRepository;

    public function __construct(SupportTicketRepository  $supportTicketRepository)
    {
        $this->supportTicketRepository= $supportTicketRepository;
    }

    public function ticketList()
	{
       return $this->supportTicketRepository->ticketList();
	}

    public function ticketListMine()
	{
       return $this->supportTicketRepository->ticketListMine();
	}

	public function ticketListWithUserReferId()
	{
       return $this->supportTicketRepository->ticketListWithUserReferId();
	}

	public function categoryList()
	{
       return $this->supportTicketRepository->categoryList();
	}

	public function priorityList()
	{
       return $this->supportTicketRepository->priorityList();
	}

	public function statusList()
	{
       return $this->supportTicketRepository->statusList();
	}

	public function agentList()
	{
       return $this->supportTicketRepository->agentList();
	}

	public function userList($id)
	{
       return $this->supportTicketRepository->userList($id);
	}

	public function create(array $data)
    {
        return $this->supportTicketRepository->create($data);
    }

    public function supportTicketWithMsgAndFile($id)
    {
    	return $this->supportTicketRepository->supportTicketWithMsgAndFile($id);
    }


    public function find($id)
    {
        return $this->supportTicketRepository->find($id);

    }

    public function update(array $data, $id)
    {
        return $this->supportTicketRepository->update($data,$id);
    }

    public function ticketWithFile($id)
    {
        return $this->supportTicketRepository->ticketWithFile($id);
    }

    public function fileDelete($id)
    {
       return $this->supportTicketRepository->fileDelete($id);
    }

    public function attachFileDelete($id){
        return $this->supportTicketRepository->attachFileDelete($id);
    }

    public function searchWithAttr($category_id,$priority_id,$status_id)
    {
      return $this->supportTicketRepository->searchWithAttr($category_id,$priority_id,$status_id);
    }

    public function searchAssignedTicketWithAttr($category_id,$priority_id,$status_id)
    {
      return $this->supportTicketRepository->searchAssignedTicketWithAttr($category_id,$priority_id,$status_id);
    }

    public function search()
    {
    	return $this->supportTicketRepository->search();
    }

    public function saveSupportTicketFile(array $data)
    {
    	return $this->supportTicketRepository->saveSupportTicketFile($data);
    }


}
