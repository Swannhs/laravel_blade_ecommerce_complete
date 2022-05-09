<?php

namespace Modules\Attendance\Repositories;

use Modules\Attendance\Entities\Attendance;
use Carbon\Carbon;
use DateTime;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\Attendance\Entities\Holiday;

class AttendanceRepository implements AttendanceRepositoryInterface
{
    public function all()
    {
        //
    }

    public function create(array $data)
    {
        $day = new DateTime($data['date']);
        
        foreach ($data['user'] as $key => $user_id) {
            $user_exist = Attendance::where('user_id', $user_id)->where('date', Carbon::parse($data['date']))->first();
            if ($user_exist == null) {
                $attendance_user = new Attendance;
                $attendance_user->user_id = $user_id;
                $attendance_user->date = Carbon::parse($data['date']);
                $attendance_user->day = $day->format('l');
                $attendance_user->month = $day->format('F');
                $attendance_user->year = now()->year;
                $attendance_user->save();
            }
        }
        foreach ($data['attendance'] as $key => $value) {
            
            $role = User::find($key)->role_id;
            $attendance = Attendance::where('user_id', $key)->where('date', Carbon::parse($data['date']))->first();
            if($attendance){
                $attendance->user_id = $key;
                $attendance->role_id = $role;
                $attendance->attendance = $value;
                $attendance->note = $data['note_' . $key];
                $attendance->save();
            }
        }
        return true;
    }

    public function get_user_by_role($id)
    {
        if($id == 0){
            $users = User::where('id', '>', 1)->where('is_active', 1)->whereHas('role', function($query){
                $query->where('type', 'admin')->orWhere('type', 'staff');
            })->get();
        }else{
            $users = User::where('id', '>', 1)->where('role_id', $id)->where('is_active', 1)->get();
        }

        return $users;
    }

    public function report(array $data)
    {
        if($data['role_id'] == 0){
            $repots = Attendance::where('month', $data['month'])->where('year', $data['year'])->get();
        }else{
            $repots = Attendance::where('role_id', $data['role_id'])->where('month', $data['month'])->where('year', $data['year'])->get();
        }
        return $repots;
    }

    public function date(array $data)
    {
        if($data['role_id'] == 0){
            $dates = Attendance::where('month', $data['month'])->where('year', $data['year'])->distinct()->get(['date']);
        }else{
            $dates = Attendance::where('month', $data['month'])->where('year', $data['year'])->distinct()->where('role_id', $data['role_id'])->get(['date']);
        }

        return $dates;
    }

    public function user(array $data)
    {
        if($data['role_id'] == 0){
            $users = User::where('id', '>', 1)->whereHas('role',function($query){
                $query->where('type', 'admin')->orWhere('type', 'staff');
            })->get();
        }else{
            $users = User::where('role_id', $data['role_id'])->get();
        }  
        return $users;
    }

    public function attendanceByDate($date,$type)
    {
        if ($type == 0)
            return Attendance::whereDate('date',date('Y-m-d', strtotime($date)))->delete();
        else
        {
            $date_range = explode(',',$date);
            $start_date = $date_range[0];
            $end_date = $date_range[1];
            return Attendance::whereBetween('date',[date('Y-m-d', strtotime($start_date)),date('Y-m-d',strtotime($end_date))])->delete();
        }

    }

}
