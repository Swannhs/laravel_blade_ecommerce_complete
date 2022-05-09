<?php

namespace Modules\Menu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class MultiMegaMenu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            Cache::forget('MegaMenu');
        });
        self::updated(function ($model) {
            Cache::forget('MegaMenu');
        });
        self::deleted(function ($model) {
            Cache::forget('MegaMenu');
        });

    }   


    public function menu(){
        return $this->belongsTo(Menu::class,'menu_id','id');
    }
    public function multiMegaMenu(){
        return $this->belongsTo(Menu::class,'multi_mega_menu_id','id');
    }
    
}
