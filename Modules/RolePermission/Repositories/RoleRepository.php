<?php

namespace Modules\RolePermission\Repositories;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\RolePermission\Entities\Role;
use Modules\RolePermission\Entities\Permission;
use Auth;


class RoleRepository
{
    public function all()
    {
        return Role::where('type', '!=','superadmin')->where('type', '!=','customer')->where('type', '!=','affiliate')->get();
    }

    public function create(array $data)
    {
        $role = new Role();
        $role->name = $data['name'];
        $role->type = 'staff';
        $role->save();
    }

    public function update(array $data, $id)
    {
        $role = Role::find($id);
        if($role && $role->type!='superadmin' && $role->type!='admin' && $role->type!='seller' && $role->id > 3){
            $role->update($data);
            return true;
        }else{
            return false;
        }
    }

    public function delete($id)
    {
        $role = Role::find($id);
        if($role && $role->type!='superadmin' && $role->type!='admin' && $role->type!='seller' && $role->id > 3){
            if(count($role->users) > 0){
                return 'not_possible';
            }
            $role->delete();
            return 'possible';
        }else{
            return 'default_role';
        }
        
    }

    public function normalRoles()
    {
        return Role::where('type','!=','admin')->get();
    }
}
