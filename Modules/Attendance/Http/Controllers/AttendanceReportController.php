<?php

namespace Modules\Attendance\Http\Controllers;

use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Attendance\Entities\Attendance;
use Modules\RolePermission\Entities\Role;
use Modules\Attendance\Http\Requests\AttendanceReportFormRequest;
use Modules\Attendance\Repositories\AttendanceRepositoryInterface;
use Modules\UserActivityLog\Traits\LogActivity;
use PDF;

class AttendanceReportController extends Controller
{
    protected $attaendanceRepository;

    public function __construct(AttendanceRepositoryInterface $attaendanceRepository)
    {
        $this->middleware(['auth', 'verified','maintenance_mode']);
        $this->attaendanceRepository = $attaendanceRepository;
        
    }
    public function index()
    {
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $roles = Role::where('id', '>', 1)->where('type','admin')->orWhere('type','staff')->get();
        return view('attendance::attendance_reports.index', compact('months', 'roles'));
    }

    public function reports(AttendanceReportFormRequest $request)
    {
        try {
            $reports = $this->attaendanceRepository->report($request->all());
            $users = $this->attaendanceRepository->user($request->all());
            $report_dates = $this->attaendanceRepository->date($request->all());

            $r = $request->role_id;
            $m = $request->month;
            $y = $request->year;
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $roles = Role::where('id', '>', 1)->where('type','admin')->orWhere('type','staff')->get();

            return view('attendance::attendance_reports.index',[
                'reports' => $reports,
                'report_dates' => $report_dates,
                'users' => $users,
                'r' => $r,
                'm' => $m,
                'y' => $y,
                'months' => $months,
                'roles' => $roles
            ]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage().' - Error has been detected for Attendance Report');
            return redirect()->back();
        }
    }

    public function attendance_report_print($role_id, $month, $year)
    {
        try{
            if($role_id == 0){
                $users = User::where('id', '>', 1)->whereHas('role', function($query){
                    $query->where('type', 'admin')->orWhere('type', 'staff');
                })->get();
            }else{
                $users = User::where('role_id', $role_id)->get();
            }

            $report_dates = Attendance::where('month', $month)->where('year', $year)->distinct()->get(['date']);

            $role = Role::find($role_id);
            $r = $role_id;
            $m = $month;
            $y = $year;
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            $customPaper = array(0, 0, 700.00, 1000.80);
            $pdf = PDF::loadView(
                'attendance::attendance_reports.staff_attendance_print',
                [
                    'report_dates' => $report_dates,
                    'users' => $users,
                    'r' => $r,
                    'm' => $m,
                    'y' => $y,
                    'role' => $role,
                    'months' => $months
                ]
            )->stream('staff_attendance.pdf');

            return $pdf;

        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
           Toastr::error(__('common.operation_failed'));
           return redirect()->back();
        }
    }
}
