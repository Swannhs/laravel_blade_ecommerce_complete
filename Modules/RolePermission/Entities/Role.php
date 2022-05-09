<?php

namespace Modules\RolePermission\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = ['id'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'role_permission','role_id','permission_id');
    }

    public function users(){
        return $this->hasMany(User::class,'role_id','id');
    }
}
