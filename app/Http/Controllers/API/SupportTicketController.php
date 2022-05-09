<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\SupportTicketService;
use Exception;
use Illuminate\Http\Request;
use Modules\SupportTicket\Entities\SupportTicketFile;
use Modules\SupportTicket\Entities\TicketMessage;
use Modules\SupportTicket\Entities\TicketMessageFile;
use Modules\SupportTicket\Repositories\SupportTicketCategoryRepository;
use Modules\SupportTicket\Repositories\TicketPriorityRepository;

class SupportTicketController extends Controller
{
    protected $supportTicketService;

    public function __construct(SupportTicketService $supportTicketService)
    {
        $this->supportTicketService = $supportTicketService;
    }

    // Ticket List
    
    public function index(Request $request){
        $tickets = $this->supportTicketService->getMyTickets($request->user()->id);
        $statuses = $this->supportTicketService->getStatuses();

        return response()->json([
            'tickets' => $tickets,
            'statuses' => $statuses,
            'msg' => 'success'
        ], 200);
    }

    // Get Ticket with paginate

    public function getTicketsWithPaginate(Request $request){
        $status = null;
        $page = null;
        if(isset($request->status)){
            $status = $request->status;
        }
        if(isset($request->page)){
            $page = $request->page;
        }

        $tickets = $this->supportTicketService->getMyTicketWithPaginate(['page'=>$page, 'status' => $status, 'user_id' => $request->user()->id]);
        $statuses = $this->supportTicketService->getStatuses();

        return response()->json([
            'tickets' => $tickets,
            'statuses' => $statuses,
            'msg' => 'success'
        ], 200);

    }

    // Ticket Store

    public function store(Request $request){
        $request->validate([
            'subject' => 'required|max:255',
            'ticket_file.*' => 'nullable|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf',
            'category_id' => 'required',
            'priority_id' => 'required',
            'description' => 'required',
        ]);

        $supportTicket = $this->supportTicketService->store($request->except('_token'), $request->user()->id);

        $files = $request->file('ticket_file');

        if($request->hasFile('ticket_file'))
        {
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

        return response()->json([
            'msg' => 'created successfully'
        ],201);

    }

    // Single Ticket

    public function show($id){
        $ticket = $this->supportTicketService->getTicketById($id);
        if($ticket){
            return response()->json([
                'ticket' => $ticket,
                'msg' => 'success'
            ],200);
        }else{
            return response()->json([
                'msg' => 'not found'
            ]);
        }
    }

    // Category List

    public function categoryList(){
        $categoryRepo = new SupportTicketCategoryRepository();
        $categories = $categoryRepo->getActiveAll();
        return response()->json([
            'categories' => $categories,
            'msg' => 'success'
        ], 200);
    }

    // Priority List

    public function priorityList(){
        $priorityRepo = new TicketPriorityRepository();
        $priorities = $priorityRepo->getActiveAll();
        return response()->json([
            'priorities' => $priorities,
            'msg' => 'success'
        ], 200);
    }

    // Ticket Reply

    public function replyTicket(Request $request){
        $request->validate([
            'text' => 'required',
            'ticket_id' => 'required|numeric',
            'ticket_file.*' => 'nullable|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf,sql',
            'status_id' => 'nullable'
        ]);

        try{
            $ticket_id = $request->input('ticket_id');
            if ($request->text != '') {
                $ticketMessage = TicketMessage::create([
                    'ticket_id' => $ticket_id,
                    'text'      => $request->input('text'),
                    'user_id' => auth()->user()->id,
                    'type' => $request->type
                ]);


                if ($request->hasFile('ticket_file')) {

                    if (!file_exists(asset_path('uploads/message_ticket_image/'))) {
                        mkdir(asset_path('uploads/message_ticket_image/'), 0777, true);
                    }

                    $files = $request->file('ticket_file');
                    foreach ($files as $file) {
                        $file_original_name = $file->getClientOriginalName();
                        $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                        $file->move(asset_path('uploads/message_ticket_image/'), $fileName);
                        $filePath = 'uploads/message_ticket_image/' . $fileName;

                        $messageFile = new TicketMessageFile();
                        $messageFile->message_id = $ticketMessage->id;
                        $messageFile->url = $filePath;
                        $messageFile->name = $file->getClientOriginalName();
                        $messageFile->type = $file->getClientOriginalExtension();
                        $messageFile->save();
                    }
                }
            }
            return response()->json([
                'msg' => 'Reply done.'
            ],201);

        }catch(Exception $e){
            return response()->json([
                'msg' => 'Something Went Wrong.'
            ],500);
        }
    }
}
