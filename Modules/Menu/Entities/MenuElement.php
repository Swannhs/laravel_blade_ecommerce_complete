<?php

namespace Modules\Menu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Modules\FrontendCMS\Entities\DynamicPage;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;
use Modules\Seller\Entities\SellerProduct;
use Modules\Setup\Entities\Tag;

class MenuElement extends Model
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

    public function category(){
        return $this->belongsTo(Category::class,'element_id','id');
    }
    public function page(){
        return $this->belongsTo(DynamicPage::class,'element_id','id');
    }
    public function product(){
        return $this->belongsTo(SellerProduct::class,'element_id','id')->activeSeller();
    }
    public function brand(){
        return $this->belongsTo(Brand::class,'element_id','id');
    }
    public function tag(){
        return $this->belongsTo(Tag::class,'element_id','id');
    }

    public function parent(){
        return $this->belongsTo(MenuElement::class,'parent_id','id');
    }
    public function childs(){
        return $this->hasMany(MenuElement::class,'parent_id','id')->orderBy('position');
    }

}
