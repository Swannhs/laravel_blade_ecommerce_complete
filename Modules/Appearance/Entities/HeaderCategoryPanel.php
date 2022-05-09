<?php

namespace Modules\Appearance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Modules\Product\Entities\Category;

class HeaderCategoryPanel extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            Cache::forget('HeaderSection');
            Cache::forget('productSectionItems');
        });
        self::updated(function ($model) {
            Cache::forget('HeaderSection');
            Cache::forget('productSectionItems');
        });
        self::deleted(function ($model) {
            Cache::forget('HeaderSection');
            Cache::forget('productSectionItems');
        });
    }  
    
    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    
}
