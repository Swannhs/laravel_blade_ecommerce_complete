<?php

namespace Modules\SupportTicket\Http\Controllers\FrontEnd;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SupportTicket\Entities\SupportTicket;
use Modules\SupportTicket\Entities\TicketCategory;
use Modules\SupportTicket\Entities\TicketPriority;
use Modules\SupportTicket\Entities\TicketStatus;
use Auth;
use Modules\SupportTicket\Entities\SupportTicketFile;
use Toastr;
use App\Admin;
use Notification;
use App\Notifications\SupportTicketNotification;
class UserSupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data['userTickets'] = SupportTicket::where('user_id', Auth::id())->get();
        $data['closedTickets'] = SupportTicket::where('user_id', Auth::id())
                                    ->where('status_id', 4)->get();
        $data['CategoryList'] = TicketCategory::latest()->get();
        $data['PriorityList'] = TicketPriority::latest()->get();
         $data['StatusList'] = TicketStatus::all();
        return view('supportticket::frontend.support.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $data['CategoryList'] = TicketCategory::latest()->get();
        $data['PriorityList'] = TicketPriority::latest()->get();
        return view('supportticket::frontend.support.create',$data);

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
         $request->validate([
                'subject' => 'required',
                'description' => 'required',
                'ticket_file.*' => 'nullable|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf,sql',
                'priority_id' => 'required',
                'category_id' => 'required'
            ],
            [
                'required' => 'This :attributes Field is required',
                'mimes' => 'File should be in jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf,sql type'
            ]);


        try{
            $rand = mt_rand(10,99);
            $time = time();
            $time = substr($time,6);
            $uliqueId = $rand . $time;

            $supportTicket = SupportTicket::create([
                'reference_no'  => $uliqueId,
                'subject'       => $request['subject'],
                'description'   => $request['description'],
                'user_id'       => Auth::id(),
                'agent_id'      => $request['agent_id'],
                'priority_id'   => $request['priority_id'],
                'category_id'   => $request['category_id'],
                'status_id'     =>  1
            ]);

            $files = $request->file('ticket_file');

                if($request->hasFile('ticket_file'))
                {
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

            $admins = Admin::all();

            Notification::send($admins, new SupportTicketNotification('New Support Ticket Created',auth()->user()->id, auth()->user()->name, auth()->user()->name . ' Has Create a new Support Ticket', $supportTicket->id));


            Toastr::success(__('common.created_successfully'),__('common.success'));
            \LogActivity::successLog('support ticket created successful.');
            return redirect()->route('support.index');
        }catch (\Exception $e) {
            \LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return $e->getMessage();
            return redirect()->back();
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($refNo)
    {
        $data['SupportTicket'] = SupportTicket::with('messages')->with('messages.attachFiles')->where('reference_no',$refNo)->first();
        $data['userTickets'] = SupportTicket::where('user_id', Auth::id())->get();
        $data['CategoryList'] = TicketCategory::latest()->get();
        $data['PriorityList'] = TicketPriority::latest()->get();
        return view('supportticket::frontend.support.show', $data);
    }


    public function filter()
    {
        $status_id = request()->input('status_id');

        if(!$status_id){
            return redirect()->route('support.index');
        }

        $data['userTickets'] = SupportTicket::with('attachFiles')
                                ->where('user_id', Auth::id())
                                ->Where('status_id', $status_id)
                                ->get();
        $data['closedTickets'] = SupportTicket::where('user_id', Auth::id())
                                    ->where('status_id', 4)->get();
        $data['StatusList'] = TicketStatus::all();
        return view('supportticket::frontend.support.index',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('supportticket::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
