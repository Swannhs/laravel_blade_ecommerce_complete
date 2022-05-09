<?php

namespace Modules\Attendance\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Attendance\Entities\Holiday;
use Modules\Attendance\Http\Requests\AttendanceFormRequest;
use Modules\Attendance\Repositories\AttendanceRepositoryInterface;
use Carbon\Carbon;
use DateTime;
use Modules\RolePermission\Entities\Role;
use Modules\UserActivityLog\Traits\LogActivity;

class AttendanceController extends Controller
{
    protected $attaendanceRepository;

    public function __construct(AttendanceRepositoryInterface $attaendanceRepository)
    {
        $this->middleware(['auth', 'verified','maintenance_mode']);
        $this->attaendanceRepository = $attaendanceRepository;
        
    }

    public function index()
    {
        $roles = Role::where('id', '>', 1)->where('type','admin')->orWhere('type','staff')->get();
        return view('attendance::attendances.index', compact('roles'));
    }

    public function create()
    {
        return view('attendance::create');
    }

    public function store(AttendanceFormRequest $request)
    {
        try {
            $this->attaendanceRepository->create($request->except("_token"));
            LogActivity::successLog('Attendance has been taken.');
            Toastr::success(__('hr.attendance_has_been_taken_successfully'), __('common.success'));
            return redirect()->route('attendances.index');
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage().' - Error has been detected for attendance creation');
            Toastr::error(__('common.error_message'), __('common.error'));
            return redirect()->back();
        }
    }

    public function show($id)
    {
        return view('attendance::show');
    }

    public function edit($id)
    {
        return view('attendance::edit');
    }

    public function get_user_by_role(Request $request)
    {
        try {
            $users = $this->attaendanceRepository->get_user_by_role($request->role_id);

            return view('attendance::attendances.create_attendance',[
                'users' => $users,
                'date' => $request->date,
            ]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return redirect()->back();
        }
    }
}
