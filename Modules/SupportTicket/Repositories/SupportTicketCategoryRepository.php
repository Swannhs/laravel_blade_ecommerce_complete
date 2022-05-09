<?php

namespace Modules\SupportTicket\Repositories;
use Modules\SupportTicket\Entities\TicketCategory;

class SupportTicketCategoryRepository
{
    public function getAll()
    {
        return TicketCategory::latest()->get();
    }
    public function getActiveAll(){
        return TicketCategory::where('status', 1)->latest()->get();
    }
    
    public function create(array $data)
    {
        return TicketCategory::create($data);
    }

    public function find($id)
    {
        return TicketCategory::findOrFail($id);
    }

    public function update(array $data)
    {
        return TicketCategory::findOrFail($data['id'])->update([
            'name' => $data['name'],
            'status' => $data['status']
        ]);
    }
    public function statusChange($data){
        return TicketCategory::findOrFail($data['id'])->update([
            'status' => $data['status']
        ]);
    }

    public function delete($id)
    {
        return TicketCategory::findOrFail($id)->delete();
    }
}

