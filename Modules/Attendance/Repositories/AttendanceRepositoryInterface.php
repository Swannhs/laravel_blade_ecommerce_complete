<?php

namespace Modules\Attendance\Repositories;


interface AttendanceRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function get_user_by_role($data);

    public function report(array $data);

    public function date(array $data);

    public function user(array $data);

    public function attendanceByDate($date,$type);
}
