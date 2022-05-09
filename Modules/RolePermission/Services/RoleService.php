<?php

namespace Modules\RolePermission\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\RolePermission\Repositories\RoleRepository;

class RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepository  $roleRepository)
    {
        $this->roleRepository= $roleRepository;
    }

  public function all()
    {
        return $this->roleRepository->all();
    }

    public function create(array $data)
    {
        return $this->roleRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->roleRepository->update($data,$id);
    }

    public function delete($id)
    {
        return $this->roleRepository->delete($id);
    }

    public function normalRoles()
    {
        return $this->roleRepository->normalRoles($id);
    }

}
