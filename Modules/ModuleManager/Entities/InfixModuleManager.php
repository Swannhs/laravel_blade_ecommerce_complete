<?php

namespace Modules\ModuleManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Rennokki\QueryCache\Traits\QueryCacheable;

class InfixModuleManager extends Model
{


    protected $table = 'infix_module_managers';
    protected $fillable = ['name','email','notes','version','purchase_code','installed_domain','activated_date','checksum'];


    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('ModuleManagerList');
        });
        self::updated(function ($model) {
            Cache::forget('ModuleManagerList');
        });
    }
}
