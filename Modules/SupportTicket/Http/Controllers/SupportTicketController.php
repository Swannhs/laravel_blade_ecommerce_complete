<?php

namespace Modules\SupportTicket\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SupportTicket\Http\Requests\SupportTicketCreateRequest;
use Modules\SupportTicket\Http\Requests\SupportTicketUpdateRequest;
use Modules\SupportTicket\Entities\SupportTicketFile;
use Auth;
use Notification;
use App\Notifications\SupportTicketNotification;
use App\Traits\SendMail;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Modules\SupportTicket\Services\SupportTicketService;
use Modules\UserActivityLog\Traits\LogActivity;
use Yajra\DataTables\Facades\DataTables;

use function Clue\StreamFilter\fun;

class SupportTicketController extends Controller
{

    use SendMail;
    protected $supportTicketService;

    public function __construct(SupportTicketService $supportTicketService)
    {
        $this->middleware(['auth', 'maintenance_mode']);
        $this->middleware('prohibited_demo_mode')->only('store','update','destroy');
        $this->supportTicketService = $supportTicketService;
    }



    public function index()
    {

        $data['CategoryList'] =  $this->supportTicketService->categoryList();
        $data['PriorityList'] = $this->supportTicketService->priorityList();
        $data['StatusList'] = $this->supportTicketService->statusList();
        $data['AgentList'] = $this->supportTicketService->agentList();

        if (isset($_GET['category_id'])) {
            $data['category_id'] = $_GET['category_id'];
        }
        if (isset($_GET['priority_id'])) {
            $data['priority_id'] = $_GET['priority_id'];
        }
        if (isset($_GET['status_id'])) {
            $data['status_id'] = $_GET['status_id'];
        }
        return view('supportticket::ticket.index', $data);
    }

    public function my_ticket()
    {

        $data['CategoryList'] =  $this->supportTicketService->categoryList();
        $data['PriorityList'] = $this->supportTicketService->priorityList();
        $data['StatusList'] = $this->supportTicketService->statusList();
        $data['AgentList'] = $this->supportTicketService->agentList();

        if (isset($_GET['category_id'])) {
            $data['category_id'] = $_GET['category_id'];
        }
        if (isset($_GET['priority_id'])) {
            $data['priority_id'] = $_GET['priority_id'];
        }
        if (isset($_GET['status_id'])) {
            $data['status_id'] = $_GET['status_id'];
        }
        return view('supportticket::ticket.assigned_ticket_index', $data);
    }

    public function getData()
    {
        $TicketList = $this->supportTicketService->ticketList();
        $AgentList = $this->supportTicketService->agentList();

        return DataTables::of($TicketList)
            ->addIndexColumn()
            ->addColumn('subject', function ($TicketList) {
                return '<a target="_blank" href="' . route('ticket.tickets.show', $TicketList->id) . '">' . $TicketList->subject . '</a>';
            })
            ->addColumn('category', function ($TicketList) {
                return $TicketList->category->name;
            })
            ->addColumn('username', function ($TicketList) {
                return view('supportticket::ticket.components._username_td', compact('TicketList'));
            })
            ->addColumn('priority', function ($TicketList) {
                return $TicketList->priority->name;
            })
            ->addColumn('assign_user', function ($TicketList) {
                return view('supportticket::ticket.components._assign_user_td', compact('TicketList'));
            })
            ->addColumn('status', function ($TicketList) {
                return $TicketList->status->name;
            })
            ->addColumn('assign_aggent', function ($TicketList) use ($AgentList) {
                return view('supportticket::ticket.components._assign_td', compact('TicketList', 'AgentList'));
                return 1;
            })
            ->addColumn('action', function ($TicketList) {
                return view('supportticket::ticket.components._action_td', compact('TicketList'));
            })
            ->rawColumns(['subject', 'username', 'assign_user', 'assign_aggent', 'action'])
            ->toJson();
    }

    public function my_ticket_get_data()
    {
        $TicketList = $this->supportTicketService->ticketListMine();

        return DataTables::of($TicketList)
            ->addIndexColumn()
            ->addColumn('subject', function ($TicketList) {
                return '<a target="_blank" href="' . route('ticket.tickets.show', $TicketList->id) . '">' . $TicketList->subject . '</a>';
            })
            ->addColumn('category', function ($TicketList) {
                return $TicketList->category->name;
            })
            ->addColumn('username', function ($TicketList) {
                return view('supportticket::ticket.components._username_td', compact('TicketList'));
            })
            ->addColumn('priority', function ($TicketList) {
                return $TicketList->priority->name;
            })
            ->addColumn('assign_user', function ($TicketList) {
                return view('supportticket::ticket.components._assign_user_td', compact('TicketList'));
            })
            ->addColumn('status', function ($TicketList) {
                return $TicketList->status->name;
            })
            ->addColumn('action', function ($TicketList) {
                return view('supportticket::ticket.components._action_assigned_td', compact('TicketList'));
            })
            ->rawColumns(['subject', 'username', 'assign_user', 'assign_aggent', 'action'])
            ->toJson();
    }


    public function create()
    {
        try {
            $data['CategoryList'] = $this->supportTicketService->categoryList();
            $data['PriorityList'] = $this->supportTicketService->priorityList();
            $data['UserList'] = $this->supportTicketService->userList(auth()->id());
            $data['StatusList'] = $this->supportTicketService->statusList();
            $data['AgentList'] = $this->supportTicketService->agentList();
            return view('supportticket::ticket.create', $data);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return redirect()->back();
        }
    }

    public function store(SupportTicketCreateRequest $request)
    {

        DB::beginTransaction();
        try {
            $this->supportTicketService->create($request->except('_token'));
            DB::commit();

            Toastr::success(__('common.created_successfully'), __('common.success'));
            LogActivity::successLog('Support ticket created successfully.');
            return redirect()->route('ticket.tickets.index');
        } catch (\Exception $e) {
            Toastr::error(__('common.error_message'), __('common.error'));
            DB::rollBack();
            LogActivity::errorLog($e->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $data['SupportTicket'] = $this->supportTicketService->supportTicketWithMsgAndFile($id);

        $data['SupportTicketStatusList'] = $this->supportTicketService->statusList();
        if (auth()->user()->role->type == 'superadmin' || auth()->user()->role->type ==  'admin') {
            $data['UserList'] = $this->supportTicketService->userList($data['SupportTicket']->user_id);
            $data['AgentList'] = $this->supportTicketService->agentList();
        }

        return view('supportticket::ticket.show', $data);
    }

    public function edit($id)
    {
        try {
            $data['CategoryList'] = $this->supportTicketService->categoryList();
            $data['PriorityList'] = $this->supportTicketService->priorityList();
            $data['UserList'] = $this->supportTicketService->userList(auth()->id());
            $data['editData'] = $this->supportTicketService->find($id);
            $data['StatusList'] = $this->supportTicketService->statusList();
            $data['AgentList'] = $this->supportTicketService->agentList();
            return view('supportticket::ticket.edit', $data);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return redirect()->back();
        }
    }

    public function update(SupportTicketUpdateRequest $request, $id)
    {
        try {
            $this->supportTicketService->update($request->except('_token'), $id);
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('Support ticket updated successfully.');
            return redirect()->route('ticket.tickets.index');
        } catch (\Exception $e) {
            Toastr::error(__('common.error_message'), __('common.error'));
            LogActivity::errorLog($e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request)
    {
        try {
            $ticket = $this->supportTicketService->ticketWithFile($request->id);
            $fileIds = [];
            foreach ($ticket->attachFiles as $key => $value) {
                if (file_exists($value->url)) {
                    unlink($value->url);
                }
                $fileIds[] = $value->id;
            }
            $this->supportTicketService->fileDelete($fileIds);
            $ticket->delete();
            Toastr::success(__('common.deleted_successfully'), __('common.success'));
            LogActivity::successLog('support ticked delete successful.');
            return redirect()->route('ticket.tickets.index');
        } catch (\Exception $e) {
            Toastr::error(__('common.error_message'), __('common.error'));
            LogActivity::errorLog($e->getMessage());
            return redirect()->back();
        }
    }

    public function attachFileDelete(Request $request)
    {
        return $this->supportTicketService->attachFileDelete($request->id);
    }

    public function search()
    {
        $category_id = request()->input('category_id');
        $priority_id = request()->input('priority_id');
        $status_id = request()->input('status_id');

        if (!$category_id && !$priority_id && !$status_id) {
            return redirect()->route('ticket.tickets.index');
        }

        if (($category_id || $priority_id || $status_id)) {
            $TicketList = $this->supportTicketService->searchWithAttr($category_id, $priority_id, $status_id);
        } else {
            $TicketList = $this->supportTicketService->search();
        }

        $AgentList = $this->supportTicketService->agentList();

        return DataTables::of($TicketList)
            ->addIndexColumn()
            ->addColumn('subject', function ($TicketList) {
                return '<a target="_blank" href="' . route('ticket.tickets.show', $TicketList->id) . '">' . $TicketList->subject . '</a>';
            })
            ->addColumn('category', function ($TicketList) {
                return $TicketList->category->name;
            })
            ->addColumn('username', function ($TicketList) {
                return view('supportticket::ticket.components._username_td', compact('TicketList'));
            })
            ->addColumn('priority', function ($TicketList) {
                return $TicketList->priority->name;
            })
            ->addColumn('assign_user', function ($TicketList) {
                return view('supportticket::ticket.components._assign_user_td', compact('TicketList'));
            })
            ->addColumn('status', function ($TicketList) {
                return $TicketList->status->name;
            })
            ->addColumn('assign_aggent', function ($TicketList) use ($AgentList) {
                return view('supportticket::ticket.components._assign_td', compact('TicketList', 'AgentList'));
                return 1;
            })
            ->addColumn('action', function ($TicketList) {
                return view('supportticket::ticket.components._action_td', compact('TicketList'));
            })
            ->rawColumns(['subject', 'username', 'assign_user', 'assign_aggent', 'action'])
            ->toJson();
    }

    public function searchAssigned()
    {
        $category_id = request()->input('category_id');
        $priority_id = request()->input('priority_id');
        $status_id = request()->input('status_id');

        if (!$category_id && !$priority_id && !$status_id) {
            return redirect()->route('ticket.my_ticket');
        }

        $TicketList = $this->supportTicketService->searchAssignedTicketWithAttr($category_id, $priority_id, $status_id);


        return DataTables::of($TicketList)
            ->addIndexColumn()
            ->addColumn('subject', function ($TicketList) {
                return '<a target="_blank" href="' . route('ticket.tickets.show', $TicketList->id) . '">' . $TicketList->subject . '</a>';
            })
            ->addColumn('category', function ($TicketList) {
                return $TicketList->category->name;
            })
            ->addColumn('username', function ($TicketList) {
                return view('supportticket::ticket.components._username_td', compact('TicketList'));
            })
            ->addColumn('priority', function ($TicketList) {
                return $TicketList->priority->name;
            })
            ->addColumn('assign_user', function ($TicketList) {
                return view('supportticket::ticket.components._assign_user_td', compact('TicketList'));
            })
            ->addColumn('status', function ($TicketList) {
                return $TicketList->status->name;
            })
            ->addColumn('action', function ($TicketList) {
                return view('supportticket::ticket.components._action_assigned_td', compact('TicketList'));
            })
            ->rawColumns(['subject', 'username', 'assign_user', 'assign_aggent', 'action'])
            ->toJson();
    }

    public function assignedAgent(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required',
            'refer_id' => 'required'
        ]);
        $ticketId = $request->input('ticket_id');
        $agentId = $request->input('refer_id');

        try {

            if ($agentId != 0) {

                // Send Mail
                $refer = User::where('id', $agentId)->first();
                if ($refer) {
                    $this->sendSupportTicketMail($refer, "You have assign for a new Support Ticket.");
                }

                $ticket = $this->supportTicketService->find($ticketId);
                $ticket->refer_id = $agentId;
                $ticket->save();
            } else {
                $ticket = $this->supportTicketService->find($ticketId);
                $ticket->refer_id = 0;
                $ticket->save();
            }
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return abort(404);
        }
    }
}
