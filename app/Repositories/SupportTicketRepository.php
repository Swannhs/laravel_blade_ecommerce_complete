<?php
namespace App\Repositories;

use Modules\SupportTicket\Entities\SupportTicket;
use Modules\SupportTicket\Entities\TicketCategory;
use Modules\SupportTicket\Entities\TicketPriority;
use Modules\SupportTicket\Entities\TicketStatus;

class SupportTicketRepository{

    public function getMyTickets($id){
        return SupportTicket::with('messages.attachMsgFile','messages.user')->where('user_id', $id)->paginate(10);
    }

    public function getMyTicketWithPaginate($data){
        if($data['status']){
            
            return SupportTicket::with('messages.attachMsgFile','messages.user')->where('user_id',$data['user_id'])->where('status_id',$data['status'])->paginate(10);
        }else{
            return SupportTicket::where('user_id', $data['user_id'])->paginate(10);
        }
    }

    public function getCategories(){
        return TicketCategory::where('status', 1)->latest()->get();
    }

    public function getPriorities(){
        return TicketPriority::where('status', 1)->latest()->get();
    }

    public function getStatuses(){
        return TicketStatus::where('status', 1)->get();
    }

    public function store($data, $user_id){
        $rand = mt_rand(10,99);
        $time = time();
        $time = substr($time,6);
        $uliqueId = $rand . $time;
        $pre = 'TIC';

        return SupportTicket::create([
            'reference_no'  => $pre . $uliqueId,
            'subject'       => $data['subject'],
            'description'   => $data['description'],
            'user_id'       => $data['user_id'] ?? $user_id,
            'priority_id'   => $data['priority_id'],
            'category_id'   => $data['category_id'],
            'status_id'     => $request['status'] ?? 1
        ]);
        
    }

    public function getTicketById($id){
        return SupportTicket::with('messages.attachMsgFile','messages.user')->where('reference_no', $id)->first();
    }
}
