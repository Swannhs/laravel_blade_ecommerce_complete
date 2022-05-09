<?php

namespace Modules\SupportTicket\Repositories;
use Modules\SupportTicket\Entities\TicketPriority;

class TicketPriorityRepository
{
    public function getAll()
    {
        return TicketPriority::latest()->get();
    }
    public function getActiveAll(){
        return TicketPriority::where('status', 1)->latest()->get();
    }
    
    public function create(array $data)
    {
        return TicketPriority::create($data);
    }

    public function find($id)
    {
        return TicketPriority::findOrFail($id);
    }

    public function update(array $data)
    {
        return TicketPriority::findOrFail($data['id'])->update([
            'name' => $data['name'],
            'status' => $data['status']
        ]);
    }

    public function statusChange($data){
        return TicketPriority::findOrFail($data['id'])->update([
            'status' => $data['status']
        ]);
    }

    public function delete($id)
    {
        return TicketPriority::findOrFail($id)->delete();
    }
}

