<?php

namespace Modules\Menu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Modules\Product\Entities\Category;

class MegaMenuRightPanel extends Model
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

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id')->with('categoryImage');
    }
    
}
