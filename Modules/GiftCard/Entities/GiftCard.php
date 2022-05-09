<?php

namespace Modules\GiftCard\Entities;

use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Modules\Review\Entities\ProductReview;
use Modules\Setup\Entities\Tag;
use Modules\Shipping\Entities\ShippingMethod;

class GiftCard extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['ActiveReviews','ProductType'];
    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if ($model->created_by == null) {
                $model->created_by = Auth::user()->id ?? null;
            }
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id ?? null;
        });
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withPivot('tag_id', 'gift_card_id');
    }

    public function uses(){
        return $this->hasMany(GiftCardUse::class,'gift_card_id','id');
    }

    public function galaryImages(){
        return $this->hasMany(GiftCardGalaryImage::class,'gift_card_id','id');
    }

    public function hasDiscount(){
        if($this->start_date <= date('Y-m-d') && $this->end_date >= date('Y-m-d')){
            return true;
        }else{
            return false;
        }
    }

    public function reviews(){
        return $this->hasMany(ProductReview::class,'product_id','id');
    }

    public function getActiveReviewsAttribute(){
        return ProductReview::where('type', 'gift_card')->where('product_id', $this->id)->latest()->paginate(10);
    }

    public function shippingMethod(){
        return $this->belongsTo(ShippingMethod::class,'shipping_id','id');
    }

    public function getIsWishlistAttribute(){
        if(auth()->check()){
            $wishlist = Wishlist::where('seller_product_id',$this->id)->where('type','gift_card')->where('user_id',auth()->user()->id)->first();
            if($wishlist){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    public function getProductTypeAttribute(){
        return 'gift_card';
    }
    
}
