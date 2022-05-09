<?php
namespace Modules\Seller\Repositories;

use Modules\SupportTicket\Entities\SupportTicket;
use Modules\SupportTicket\Entities\SupportTicketFile;
use Modules\SupportTicket\Entities\TicketCategory;
use Modules\SupportTicket\Entities\TicketMessage;
use Modules\SupportTicket\Entities\TicketMessageFile;
use Modules\SupportTicket\Entities\TicketPriority;
use Modules\SupportTicket\Entities\TicketStatus;

class SupportTicketRepository {

    public function getTickets(){
        return SupportTicket::where('user_id', auth()->user()->id)->latest();
    }

    public function categoryList(){

        return TicketCategory::where('status', 1)->latest()->get();
    }

    public function priorityList(){

        return TicketPriority::where('status', 1)->latest()->get();
    }

    public function statusList(){

        return TicketStatus::where('status', 1)->latest()->get();
    }
    public function getById($id){
        return SupportTicket::findOrFail($id);
    }

    public function getBySearch($category_id,$priority_id,$status_id){

        $tickets = SupportTicket::where('user_id',auth()->user()->id)->latest();
        if($category_id){
            $tickets->where('category_id',$category_id);
        }

        if($priority_id){
            $tickets->where('priority_id',$priority_id);
        }

        if($status_id){
            $tickets->where('status_id',$status_id);
        }

        return $tickets;
    }

    public function store($data){
        $pre = 'TIC';
        $rand = mt_rand(10,99);
        $time = time();
        $time = substr($time,6);
        $uliqueId = $rand . $time;

        $supportTicket = SupportTicket::create([
            'reference_no' => $pre . $uliqueId,
            'subject'       => $data['subject'],
            'description'   => $data['description'],
            'user_id'       => $data['user_id'] ?? auth()->user()->id,
            'priority_id'   => $data['priority_id'],
            'category_id'   => $data['category_id'],
            'status_id'      => $data['status'] ?? 1
        ]);




        if(isset($data['ticket_file']))
        {
            $files = $data['ticket_file'];
            if (!file_exists('uploads/support_ticket')) {
                mkdir('uploads/support_ticket', 0777, true);
            }
            foreach ($files as $file) {
                 $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('uploads/support_ticket/', $fileName);
                $filePath = 'uploads/support_ticket/' . $fileName;


                $ticketFile = new SupportTicketFile();
                $ticketFile->attachment_id = $supportTicket->id;
                $ticketFile->url = $filePath;
                $ticketFile->name = $file->getClientOriginalName();
                $ticketFile->type = $file->getClientOriginalExtension();
                $supportTicket->attachFiles()->save($ticketFile);

            }
        }
        return $supportTicket;

    }

    public function update($data, $id){
        
        $supportTicket = SupportTicket::where('id', $id)->first();
        $supportTicket->update([
            'subject'       => $data['subject'],
            'description'   => $data['description'],
            'priority_id'   => $data['priority_id'],
            'category_id'   => $data['category_id']
        ]);

        if(isset($data['ticket_file']))
        {
            $files = $data['ticket_file'];
            if (!file_exists('uploads/support_ticket')) {
                mkdir('uploads/support_ticket', 0777, true);
            }
            foreach ($files as $file) {
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('uploads/support_ticket/', $fileName);
                $filePath = 'uploads/support_ticket/' . $fileName;


                $ticketFile = new SupportTicketFile();
                $ticketFile->attachment_id = $id;
                $ticketFile->url = $filePath;
                $ticketFile->name = $file->getClientOriginalName();
                $ticketFile->type = $file->getClientOriginalExtension();
                $supportTicket->attachFiles()->save($ticketFile);

            }
        }
        return true;
    }

    public function createMessage($data){

        $ticketMessage = TicketMessage::create([
            'ticket_id' => $data['ticket_id'],
            'text' => $data['text'],
            'user_id' => auth()->user()->id,
            'type' => $data['type']
        ]);



        if(isset($data['ticket_file']))
        {
            $files = $data['ticket_file'];

            if (!file_exists('uploads/support_ticket')) {
                mkdir('uploads/support_ticket', 0777, true);
            }
            foreach ($files as $file) {
                $file_original_name = $file->getClientOriginalName();
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('uploads/message_ticket_image/', $fileName);
                $filePath = 'uploads/message_ticket_image/' . $fileName;

                $messageFile = new TicketMessageFile();
                $messageFile->message_id = $ticketMessage->id;
                $messageFile->url = $filePath;
                $messageFile->name = $file->getClientOriginalName();
                $messageFile->type = $file->getClientOriginalExtension();
                $messageFile->save();

            }
        }

        return true;

    }
}
