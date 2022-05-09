<?php

namespace Modules\Attendance\Repositories;

interface EventRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function find($id);

    public function update(array $data,$id);

    public function delete($id);

    public function roleWiseEvents();

}
