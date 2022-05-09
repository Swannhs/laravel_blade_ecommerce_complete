<?php

namespace Modules\Attendance\Repositories;

interface HolidayRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function find($id);

    public function copyYear($year);

    public function year($year);

    public function getHoliday($date);
}
