<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\GiftCard\Entities\GiftCard;
use Modules\Seller\Entities\SellerProduct;

class Wishlist extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            if(!isModuleActive('MultiVendor') && auth()->check()){
                if(auth()->user()->role->type == 'superadmin' || auth()->user()->role->type == 'admin' || auth()->user()->role->type == 'staff'){
                    $lists = Wishlist::whereHas('user', function($q){
                        return $q->where('role_id', '!=', 4);
                    })->pluck('id');
                    Wishlist::destroy($lists);
                }
            }
        });
    }

    public function product(){
        return $this->belongsTo(SellerProduct::class, 'seller_product_id')->activeSeller();
    }

    public function giftcard(){
        return $this->belongsTo(GiftCard::class, 'seller_product_id', 'id');
    }

    public function seller(){
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
