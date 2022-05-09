<?php

namespace Modules\SidebarManager\Entities;

use Illuminate\Database\Eloquent\Model;

class Sidebar extends Model
{
    protected $fillable = ['sidebar_id','user_id','position','module_id','module','parent_id','name','route','type','status','created_by','updated_by'];

    public function scopeActive($query)
    {
        $query->where('status',1);
    }
}
