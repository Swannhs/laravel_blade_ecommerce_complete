<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\SupportTicketService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Modules\SupportTicket\Entities\SupportTicketFile;
use Modules\UserActivityLog\Traits\LogActivity;

class SupportTicketController extends Controller
{
    protected $supportTicketService;

    public function __construct(SupportTicketService $supportTicketService)
    {
        $this->supportTicketService = $supportTicketService;
        $this->middleware(['maintenance_mode','auth']);
    }
    public function index(){
        $tickets = $this->supportTicketService->getMyTickets(auth()->user()->id);
        $statuses = $this->supportTicketService->getStatuses();
        return view(theme('pages.ticket.index'),compact('tickets', 'statuses'));
    }

    public function dataWithPaginate(){
        $status = null;
        $page = null;
        if(isset($_GET['status'])){
            $status = $_GET['status'];
        }
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }
        $tickets = $this->supportTicketService->getMyTicketWithPaginate(['page'=>$page, 'status' => $status, 'user_id' => auth()->user()->id]);
        $statuses = $this->supportTicketService->getStatuses();

        return view(theme('pages.ticket.partials._ticket_list_with_paginate'),compact('tickets', 'statuses','status'));
    }

    public function create(){
        $categories = $this->supportTicketService->getCategories();
        $priorities = $this->supportTicketService->getPriorities();
        return view(theme('pages.ticket.create'),compact('categories', 'priorities'));
    }

    public function store(Request $request){
        $request->validate([
            'subject' => 'required|max:255',
            'ticket_file.*' => 'nullable|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf',
            'category_id' => 'required',
            'priority_id' => 'required',
            'description' => 'required',
        ]);

        $supportTicket = $this->supportTicketService->store($request->except('_token'), auth()->user()->id);

        $files = $request->file('ticket_file');

        if($request->hasFile('ticket_file'))
        {
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

        Toastr::success(__('common.created_successfully'),__('common.success'));
        LogActivity::successLog('Support ticket create successful.');
        return redirect()->route('frontend.support-ticket.index');
    }

    public function show($id){
        $ticket = $this->supportTicketService->getTicketById($id);
        return view(theme('pages.ticket.show'),compact('ticket'));
    }
}
