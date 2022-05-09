<?php
namespace Modules\Setup\Services;

use Illuminate\Support\Facades\Validator;
use Modules\Setup\Repositories\DepartmentRepository;

class DepartmentService
{
    protected $departmentRepository;

    public function __construct(DepartmentRepository  $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function all()
    {
        return $this->departmentRepository->all();
    }

    public function create($data)
    {
        return $this->departmentRepository->create($data);
    }

    public function update($data, $id)
    {
        return $this->departmentRepository->update($data, $id);
    }

    public function find($id)
    {
        return $this->departmentRepository->find($id);
    }

    public function delete($id)
    {
        return $this->departmentRepository->delete($id);
    }
}
