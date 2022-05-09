<?php

namespace Modules\Setup\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\GiftCard\Entities\GiftCard;
use Modules\Product\Entities\Product;
use Modules\Seller\Entities\SellerProduct;

class Tag extends Model
{
    use HasFactory;
    protected $table = 'tags';
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            Cache::forget('MegaMenu');
            Cache::forget('HeaderSection');
        });
        self::updated(function ($model) {
            Cache::forget('MegaMenu');
            Cache::forget('HeaderSection');
        });
        self::deleted(function ($model) {
            Cache::forget('MegaMenu');
            Cache::forget('HeaderSection');
        });

    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('tag_id', 'product_id');
    }
    public function giftCards(){
        return $this->belongsToMany(GiftCard::class);
    }

    public function getFrontendProductsAttribute(){
        return SellerProduct::with('product')->whereHas('product', function($query){
            return $query->whereHas('tags', function($q){
                return $q->where('tag_id', $this->id);
            });
        })->activeSeller()->paginate(10);
        
    }
}
