<?php

namespace Modules\SupportTicket\Repositories;
use Modules\SupportTicket\Entities\TicketStatus;

class TicketStatusRepository
{
    public function getAll()
    {
        return TicketStatus::latest()->get();
    }

    public function getActiveAll(){
        return TicketStatus::where('status', 1)->latest()->get();
    }
    
    public function create(array $data)
    {
        return TicketStatus::create($data);
    }

    public function find($id)
    {
        return TicketStatus::findOrFail($id);
    }

    public function update(array $data)
    {
        return TicketStatus::findOrFail($data['id'])->update([
            'name' => $data['name'],
            'status' => $data['status']
        ]);
    }

    public function statusChange($data){
        return TicketStatus::findOrFail($data['id'])->update([
            'status' => $data['status']
        ]);
    }

    public function delete($id)
    {
        return TicketStatus::findOrFail($id)->delete();
    }
}

