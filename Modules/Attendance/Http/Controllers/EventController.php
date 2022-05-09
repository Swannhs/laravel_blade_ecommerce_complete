<?php

namespace Modules\Attendance\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Modules\Attendance\Entities\Event;
use Modules\Attendance\Repositories\EventRepositoryInterface;
use Modules\RolePermission\Repositories\RoleRepository;
use Modules\UserActivityLog\Traits\LogActivity;

class EventController extends Controller
{

    protected $eventRepository,$roleRepository;

    public function __construct(EventRepositoryInterface $eventRepository,RoleRepository $roleRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->roleRepository = $roleRepository;
        $this->middleware('maintenance_mode');
        $this->middleware('prohibited_demo_mode')->only('store','update','destroy');
    }

    public function index()
    {
        try {
            $events = $this->eventRepository->all();
            $roles = $this->roleRepository->normalRoles();
            return view('attendance::events.index', compact('events','roles'));
        } catch (\Exception $e) {
            Toastr::error(__('common.error_message'), __('common.error'));
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'for_whom' => 'required',
            'location' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'image' => 'nullable|mimes:jpg,png,jpeg,bmp',
            'description' => 'nullable|max:255'
        ]);

        try {
            $this->eventRepository->create($request->except('_token'));
            Toastr::success(__('common.created_successfully'), __('common.success'));
            LogActivity::successLog('Event Created Successfully.');
            return back();
        } catch (\Exception $e) {
            Toastr::error(__('common.error_message'), __('common.error'));
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }

    public function show($id)
    {
        return view('attendance::show');
    }

    public function edit($id)
    {
        try {
            $events = $this->eventRepository->all();
            $editData = $this->eventRepository->find($id);
            $roles = $this->roleRepository->normalRoles();
            return view('attendance::events.index', compact('events','editData','roles'));
        } catch (\Exception $e) {
            Toastr::error(__('common.error_message'), __('common.error'));
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'for_whom' => 'required',
            'location' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'image' => 'nullable|mimes:jpg,png,jpeg,bmp'
        ]);
        try {
            $events = $this->eventRepository->update($request->except('_token'),$id);
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('Event Updated Successfully.');
            return redirect()->route('events.index');
        } catch (\Exception $e) {
            Toastr::error(__('common.error_message'), __('common.error'));
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $this->eventRepository->delete($id);
            Toastr::success(__('common.deleted_successfully'), __('common.success'));
            LogActivity::successLog('Event Deleted Successfully.');
            return back();
        } catch (\Exception $e) {
            Toastr::error(__('common.error_message'), __('common.error'));
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }
}
