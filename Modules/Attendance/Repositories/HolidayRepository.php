<?php

namespace Modules\Attendance\Repositories;

use Carbon\CarbonPeriod;
use DateTime;
use Modules\Attendance\Entities\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Modules\Attendance\Entities\Holiday;
use Modules\RolePermission\Entities\Role;
use Modules\RolePermission\Repositories\RoleRepository;

class HolidayRepository implements HolidayRepositoryInterface
{
    public function all()
    {
        return Holiday::all();
    }

    public function create(array $data)
    {

        Holiday::where('year', $data['year'])->delete();

        foreach ($data['holiday_name'] as $key => $name) {

            if ($data['holiday_name'][$key]) {
                Holiday::create([
                    'year' => $data['year'],
                    'name' => $data['holiday_name'][$key],
                    'type' => $data['type'][$key],
                    'date' => $data['type'][$key] == 0 ? Carbon::parse($data['date'][$key])->format('Y-m-d') : Carbon::parse($data['start_date'][$key])->format('Y-m-d') . ',' . Carbon::parse($data['end_date'][$key])->format('Y-m-d'),
                ]);

                $date = $data['type'][$key] == 0 ? $data['date'][$key] : $data['start_date'][$key] . ',' . $data['end_date'][$key];
                $attendance_repo = new AttendanceRepository();
                $roles = Role::where('id', '>', 1)->where('type', 'admin')->orWhere('type', 'staff')->get();
                $attendance_repo->attendanceByDate($date,$data['type'][$key]);
                foreach ($roles as $role) {
                    $users = $attendance_repo->get_user_by_role($role->id);
                    $dates =[];

                    if ($data['type'][$key] == 1)
                    {
                    $period =  CarbonPeriod::create(Carbon::parse($data['start_date'][$key])->format('Y-m-d'), Carbon::parse($data['end_date'][$key])->format('Y-m-d'));
                    foreach ($period as $date)
                        $dates[] = $date->format('Y-m-d');
                    }

                    foreach ($users as $k => $user) {

                        if ($data['type'][$key] == 0)
                        {
                            $attendance_user = new Attendance;
                            $attendance_user->user_id = $user->id;
                            $attendance_user->date = Carbon::parse($data['date'][$key]);
                            $attendance_user->day = Carbon::parse($data['date'][$key])->format('l');
                            $attendance_user->month = Carbon::parse($data['date'][$key])->format('F');
                            $attendance_user->year = Carbon::parse($data['date'][$key])->year;
                            $attendance_user->role_id = $role->id;
                            $attendance_user->attendance = 'H';
                            $attendance_user->note = "Holiday for {$name}";
                            $attendance_user->save();
                        }
                        else{
                            foreach ($dates as $date)
                            {
                                $attendance_user = new Attendance;
                                $attendance_user->user_id = $user->id;
                                $attendance_user->date = $date;
                                $attendance_user->day = Carbon::parse($date)->format('l');
                                $attendance_user->month = Carbon::parse($date)->format('F');
                                $attendance_user->year = Carbon::parse($date)->year;
                                $attendance_user->role_id = $role->id;
                                $attendance_user->attendance = 'H';
                                $attendance_user->note = "Holiday for {$name}";
                                $attendance_user->save();
                            }
                        }

                    }

                }
            }
        }

    }

    public function find($id)
    {
        return Holiday::find($id);
    }

    public function year($year)
    {
        $year = isset($year) ? $year : Carbon::now()->year;
        return Holiday::where('year', $year)->get();
    }

    public function specificYear($year)
    {
        return Holiday::where('year', $year)->get();
    }

    public function copyYear($selected_year)
    {
        $holidays = Holiday::where('year', Carbon::create($selected_year)->subYears(1)->year)->get();
        if(count($holidays) > 0){
            foreach ($holidays as $key => $holiday) {
                $start_date=$end_date=$single_date= '';
                if ($holiday->type == 1)
                {
                    $range = explode(',',$holiday->date);
                    $start_date = Carbon::parse($range[0])->addYears(1)->format('Y-m-d');
                    $end_date = Carbon::parse($range[1])->addYears(1)->format('Y-m-d');
                }
                else
                    $single_date = Carbon::parse($holiday->date)->addYears(1)->format('Y-m-d');
                $holiday_date =$holiday->type == 0 ? $single_date :$start_date.','.$end_date ;
                Holiday::create([
                    'year' => date('Y'),
                    'name' => $holiday->name,
                    'type' => $holiday->type,
                    'date' => $holiday_date
                ]);
                $attendance_repo = new AttendanceRepository();
                $attendance_repo->attendanceByDate($holiday_date,$holiday->type);
                $roles = Role::where('id', '>', 1)->where('type', 'admin')->orWhere('type', 'staff')->get();
                foreach ($roles as $role) {
                    $users = $attendance_repo->get_user_by_role($role->id);
                    $dates =[];

                    if ($holiday->type == 1)
                    {
                        $date = explode(',',$holiday_date);
                        $period =  CarbonPeriod::create($date[0], $date[1]);
                        foreach ($period as $date)
                            $dates[] = $date->format('Y-m-d');
                    }

                    foreach ($users as $k => $user) {

                        if ($holiday->type == 0)
                        {
                            $attendance_user = new Attendance;
                            $attendance_user->user_id = $user->id;
                            $attendance_user->date = $single_date;
                            $attendance_user->day = Carbon::parse($single_date)->format('l');
                            $attendance_user->month = Carbon::parse($single_date)->format('F');
                            $attendance_user->year = Carbon::parse($single_date)->year;
                            $attendance_user->role_id = $role->id;
                            $attendance_user->attendance = 'H';
                            $attendance_user->note = "Holiday for {$holiday->name}";
                            $attendance_user->save();
                        }
                        else{
                            foreach ($dates as $date)
                            {
                                $attendance_user = new Attendance;
                                $attendance_user->user_id = $user->id;
                                $attendance_user->date = $date;
                                $attendance_user->day = Carbon::parse($date)->format('l');
                                $attendance_user->month = Carbon::parse($date)->format('F');
                                $attendance_user->year = Carbon::parse($date)->year;
                                $attendance_user->role_id = $role->id;
                                $attendance_user->attendance = 'H';
                                $attendance_user->note = "Holiday for {$holiday->name}";
                                $attendance_user->save();
                            }

                        }

                    }

                }
            }
            return true;
        }
        return false;

    }

    public function getHoliday($date)
    {
        return Holiday::where('date', $date)->latest()->first();
    }
}
