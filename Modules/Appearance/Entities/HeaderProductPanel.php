<?php

namespace Modules\Appearance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Modules\Seller\Entities\SellerProduct;

class HeaderProductPanel extends Model
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

    public function product(){
        return $this->belongsTo(SellerProduct::class,'product_id','id');
    }
}
