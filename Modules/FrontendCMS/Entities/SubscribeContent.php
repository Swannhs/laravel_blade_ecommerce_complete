<?php

namespace Modules\FrontendCMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class SubscribeContent extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            Cache::forget('popupContent');
            Cache::forget('suscriptionContent');
        });
        self::updated(function ($model) {
            Cache::forget('popupContent');
            Cache::forget('suscriptionContent');
        });
    } 
}
