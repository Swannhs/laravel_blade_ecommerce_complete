<?php

namespace Modules\SupportTicket\Repositories;

use Modules\SupportTicket\Entities\SupportTicket;
use Modules\SupportTicket\Entities\TicketCategory;
use Modules\SupportTicket\Entities\TicketPriority;
use Modules\SupportTicket\Entities\TicketStatus;
use Modules\SupportTicket\Entities\SupportTicketFile;
use App\Models\User;
use App\Traits\SendMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SupportTicketRepository
{
    use SendMail;

    public function ticketList()
    {
        return SupportTicket::with(['attachFiles', 'user', 'category', 'priority', 'status'])->latest();
    }

    public function ticketListMine()
    {
        return SupportTicket::with(['attachFiles', 'user'])->where('refer_id', auth()->user()->id)->latest();
    }

    public function ticketListWithUserReferId()
    {
        return SupportTicket::where('user_id', auth()->id())->orWhere('refer_id', auth()->id())->orWhere('refer_id', null)->with('attachFiles')->latest()->get();
    }

    public function categoryList()
    {
        return TicketCategory::where('status', 1)->latest()->get();
    }

    public function priorityList()
    {
        return TicketPriority::where('status', 1)->latest()->get();
    }

    public function statusList()
    {
        return TicketStatus::where('status', 1)->latest()->get();
    }

    public function agentList()
    {
        return User::whereNotIn('role_id', [4, 5, 6])->get();
    }

    public function userList($id)
    {
        return User::whereNotIn('role_id', [1, 2, 3])->where('id', '!=', $id)->latest()->get();
    }

    public function create(array $data)
    {
        $rand = mt_rand(10, 99);
        $time = time();
        $time = substr($time, 6);
        $pre = 'TIC-';
        $uliqueId = $rand . $time;

        $supportTicket = SupportTicket::create([
            'reference_no'  => $pre . $uliqueId,
            'subject'       => $data['subject'],
            'description'   => $data['description'],
            'user_id'       => $data['user_id'] ?? auth()->user()->id,
            'refer_id'      => isset($data['refer_id']) ? $data['refer_id'] : null,
            'priority_id'   => $data['priority_id'],
            'category_id'   => $data['category_id'],
            'status_id'      => $data['status'] ?? 1
        ]);

        $files = isset($data['ticket_file']) ? $data['ticket_file'] : null;

        if ($files != null) {
            if (!file_exists(asset_path('uploads/support_ticket/'))) {
                mkdir(asset_path('uploads/support_ticket/'), 0777, true);
            }
            foreach ($files as $file) {
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move(asset_path('uploads/support_ticket/'), $fileName);
                $filePath = 'uploads/support_ticket/' . $fileName;


                $ticketFile = new SupportTicketFile();
                $ticketFile->attachment_id = $supportTicket->id;
                $ticketFile->url = $filePath;
                $ticketFile->name = $file->getClientOriginalName();
                $ticketFile->type = $file->getClientOriginalExtension();
                $supportTicket->attachFiles()->save($ticketFile);
            }
        }


        // Send Mail to user and assigned person
        $user = User::where('id', $data['user_id'] ?? auth()->user()->id)->first();
        $this->sendSupportTicketMail($user, "New Support Ticketd Created.");

        $refer = User::where('id', isset($data['refer_id']) ? $data['refer_id'] : null)->first();
        if ($refer) {
            $this->sendSupportTicketMail($refer, "New Support Ticketd Created.");
        }


        return true;
    }

    public function supportTicketWithMsgAndFile($id)
    {

        return SupportTicket::with('messages')->with('messages.attachFiles')->findOrFail($id);
    }

    public function find($id)
    {
        return SupportTicket::with('attachFiles')->where('id', $id)->first();
    }

    public function update(array $data, $id)
    {

        $supportTicket = SupportTicket::findOrFail($id);
        $supportTicket->update([
            'subject'       => $data['subject'],
            'description'   => $data['description'],
            'user_id'       => isset($data['user_id']) ? $data['user_id'] : null,
            'refer_id'      => isset($data['refer_id']) ? $data['refer_id'] : null,
            'priority_id'   => $data['priority_id'],
            'category_id'   => $data['category_id'],
            'status_id'     => $data['status']
        ]);

        $files = isset($data['ticket_file']) ? $data['ticket_file'] : null;

        if ($files != null) {

            if (!file_exists(asset_path('uploads/support_ticket/'))) {
                mkdir(asset_path('uploads/support_ticket/'), 0777, true);
            }
            foreach ($files as $file) {
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move(asset_path('uploads/support_ticket/'), $fileName);
                $filePath = 'uploads/support_ticket/' . $fileName;


                $ticketFile = new SupportTicketFile();
                $ticketFile->attachment_id = $supportTicket->id;
                $ticketFile->url = $filePath;
                $ticketFile->name = $file->getClientOriginalName();
                $ticketFile->type = $file->getClientOriginalExtension();
                $supportTicket->attachFiles()->save($ticketFile);
            }
        }

        // Send Mail to user and assigned person
        $user = User::where('id', isset($data['user_id']) ? $data['user_id'] : null)->first();
        if ($user) {
            $this->sendSupportTicketMail($user, "Support Ticketd Updated.");
        }
        $refer = User::where('id', isset($data['refer_id']) ? $data['refer_id'] : null)->first();
        if ($refer) {
            $this->sendSupportTicketMail($refer, "Support Ticketd Updated.");
        }
        return true;
    }

    public function ticketWithFile($id)
    {

        return SupportTicket::where('id', $id)->with('attachFiles')->first();
    }

    public function fileDelete($id)
    {
        return SupportTicketFile::whereIn('id', $id)->delete();
    }

    public function attachFileDelete($id)
    {
        $file = SupportTicketFile::findOrFail($id);
        File::delete($file->url);
        $file->delete();
        return true;
    }

    public function searchWithAttr($category_id, $priority_id, $status_id)
    {

        $supportTicket = SupportTicket::with(['attachFiles', 'user', 'category', 'priority', 'status']);

        if ($category_id != null) {
            $supportTicket->where('category_id', $category_id);
        }

        if ($priority_id != null) {
            $supportTicket->where('priority_id', $priority_id);
        }

        if ($status_id != null) {
            $supportTicket->where('status_id', $status_id);
        }

        return $supportTicket;
    }

    public function searchAssignedTicketWithAttr($category_id, $priority_id, $status_id)
    {
        $supportTicket = SupportTicket::query();
        if ($status_id) {
            $supportTicket->where('status_id', $status_id);
        }
        if ($category_id) {
            $supportTicket->where('category_id', $category_id);
        }
        if ($priority_id) {
            $supportTicket->where('priority_id', $priority_id);
        }
        return $supportTicket->with(['attachFiles', 'user', 'category', 'priority', 'status'])->where('refer_id', auth()->id())->latest();
    }

    public function search()
    {

        return SupportTicket::with(['attachFiles', 'user', 'category', 'priority', 'status'])->orderBy('updated_at', 'desc');
    }

    public function saveSupportTicketFile(array $data)
    {
        return SupportTicketFile::create($data);
    }
}
