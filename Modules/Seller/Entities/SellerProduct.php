<?php

namespace Modules\Seller\Entities;

use App\Models\OrderProductDetail;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Modules\Appearance\Entities\HeaderProductPanel;
use Modules\Appearance\Entities\HeaderSliderPanel;
use Modules\FrontendCMS\Entities\HomepageCustomProduct;
use Modules\Marketing\Entities\FlashDeal;
use Modules\Marketing\Entities\FlashDealProduct;
use Modules\Marketing\Entities\NewUserZoneProduct;
use Modules\Menu\Entities\MenuElement;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductSku;
use Modules\Review\Entities\ProductReview;
use Modules\Product\Entities\ProductRelatedSale;
use Modules\Product\Entities\ProductCrossSale;
use Modules\Product\Entities\ProductUpSale;

class SellerProduct extends Model
{
    use HasFactory;

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

    protected $guarded = ['id'];
    protected $with = ['flashDeal'];

    protected $appends = ['variantDetails', 'MaxSellingPrice', 'hasDeal', 'rating', 'hasDiscount','ProductType'];

    public function productSKU()
    {
        return $this->belongsTo(ProductSku::class, "product_sku", "id");
    }

    public function skus()
    {
        return $this->hasMany(SellerProductSKU::class, 'product_id', 'id');
    }


    public function related_sales()
    {
        return $this->hasMany(ProductRelatedSale::class, 'product_id', 'product_id');
    }

    public function cross_sales()
    {
        return $this->hasMany(ProductCrossSale::class, 'product_id', 'product_id');
    }

    public function up_sales()
    {
        return $this->hasMany(ProductUpSale::class, 'product_id', 'product_id');
    }

    public function scopeHasPrice($query)
    {
        return $query->whereHas('skus')
            ->orderBy('skus.selling_price', 'desc');
    }

    public function getMaxSellingPriceAttribute()
    {
        return $this->skus->max('selling_price');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getVariantDetailsAttribute()
    {
        $product = $this->load('skus', 'skus.product_variations');
        $attr_value = array();

        foreach ($product->skus as $key => $sku) {
            foreach ($sku->product_variations as $k => $variation) {
                $blank = new \stdClass();
                $blank->value = [];
                $blank->code = [];
                $blank->attr_val_id = [];

                if (sizeof(array_filter($attr_value, function ($object) use ($variation) {
                    return $object->name == $variation->attribute->name;
                }))) {
                    foreach ($attr_value as $key => $object) {
                        $val_name = @$variation->attribute_value->color ? @$variation->attribute_value->color->name : @$variation->attribute_value->value;
                        $code = $variation->attribute_value->value;
                        $val_id = @$variation->attribute_value->color ? @$variation->attribute_value->color->attribute_value_id : @$variation->attribute_value->id;
                        if ($variation->attribute->name == $object->name) {
                            if (!in_array($val_name, $object->value, true)) {
                                array_push($object->value, $val_name);
                                array_push($object->code, $code);
                                array_push($object->attr_val_id, $val_id);
                            }
                        }
                    }
                } else {
                    $val_name = @$variation->attribute_value->color ? @$variation->attribute_value->color->name : @$variation->attribute_value->value;
                    $val_id = @$variation->attribute_value->color ? @$variation->attribute_value->color->attribute_value_id : @$variation->attribute_value->id;
                    $code = $variation->attribute_value->value;
                    $blank->name = $variation->attribute->name;
                    $blank->attr_id = $variation->attribute->id;
                    array_push($attr_value, $blank);
                    array_push($blank->value, $val_name);
                    array_push($blank->code, $code);
                    array_push($blank->attr_val_id, $val_id);
                }
            }
        }
        return $attr_value;
    }

    public function flashDealProducts()
    {
        return $this->hasMany(FlashDealProduct::class, 'seller_product_id', 'id');
    }

    public function newUserZoneProducts()
    {
        return $this->hasMany(NewUserZoneProduct::class, 'seller_product_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id', 'id')->where('type', 'product')->where('status', 1);
    }

    public function getActiveReviewsWithPaginateAttribute()
    {
        return ProductReview::where('product_id', $this->id)->where('status', 1)->latest()->paginate(10);
    }

    public function scopeActiveSeller($query)
    {
        $query = $query->where('user_id', 1)->whereHas('product', function($q){
            return $q->where('status', 1);
        })->where('status', 1);

        if(isModuleActive('MultiVendor')){
            $query = $query->orWhereHas('seller', function ($q) {
                return $q->whereHas('SellerAccount', function ($q1) {
                    return $q1->where('holiday_mode', 0)->orWhere('holiday_date', '!=', date('Y-m-d'))->orWhere(function ($q2) {
                        return $q2->where('holiday_date_start', '>', date('Y-m-d'))->where('holiday_date_end', '<', date('Y-m-d'))
                            ->orWhere('holiday_date_start', '>', date('Y-m-d'))->orWhere('holiday_date_end', '<', date('Y-m-d'));
                    });
                })
                ->whereHas('SellerSubscriptions', function ($q5) {
                    return $q5->where('expiry_date', '>', date('Y-m-d'))->whereHas('user.SellerAccount', function ($q6) {
                        return $q6->where('seller_commission_id', 3);
                    });
                })->where('is_active', 1)->orWhereHas('SellerAccount',function($q7){
                    return $q7->where('seller_commission_id','!=',3)
                    ->where('holiday_mode', 0)->orWhere('holiday_date', '!=', date('Y-m-d'))->orWhere(function ($q2) {
                        return $q2->where('holiday_date_start', '>', date('Y-m-d'))->where('holiday_date_end', '<', date('Y-m-d'))
                            ->orWhere('holiday_date_start', '>', date('Y-m-d'))->orWhere('holiday_date_end', '<', date('Y-m-d'));
                    });
                })->where('is_active', 1);
            })->where('status', 1);
        }
        
        return $query;
    }


    public function getRatingAttribute()
    {
        $reviews = $this->reviews;
        if (count($reviews) > 0) {
            $value = 0;
            $rating = 0;
            foreach ($reviews as $review) {
                $value += $review->rating;
            }
            $rating = $value / count($reviews);
            $total_review = count($reviews);
        } else {
            $rating = 0;
            $total_review = 0;
        }

        return $rating;
    }

    public function getHasDealAttribute()
    {
        
        if(!$this->relationLoaded('flashDeal')){
            return 0;
        }
            $dealproduct = $this->flashDeal;

            if(!$dealproduct){
                return 0;
            }

            $start_date = date('Y/m/d', strtotime($dealproduct->flashDeal->start_date));
            $end_date = date('Y/m/d', strtotime($dealproduct->flashDeal->end_date));
            $current_date = date('Y/m/d');

            if ($start_date <= $current_date && $end_date >= $current_date) {
                return $dealproduct;
            } 
               
            return 0;
            

       
    }

    public function flashDeal(){
        return $this->hasOne(FlashDealProduct::class, 'seller_product_id', 'id')->with('flashDeal')->whereHas('flashDeal', function($q){
            return $q->where('status', 1);
        });
    }

    public function gethasDiscountAttribute()
    {
        if ($this->discount_start_date != null && $this->discount_end_date != null) {
            $start_date = date('m/d/Y', strtotime($this->discount_start_date));
            $end_date = date('m/d/Y', strtotime($this->discount_end_date));
            if ($this->discount > 0) {
                if ($start_date < date('m/d/Y') && $end_date > date('m/d/Y')) {
                    return 'yes';
                } else {
                    return 'no';
                }
            } else {
                return 'no';
            }
        } else {
            if ($this->discount > 0) {
                return 'yes';
            } else {
                return 'no';
            }
        }
    }

    public function is_wishlist()
    {
        
        if ($this->wishList) {
            return 1;
        } else {
            return 0;
        }
       
    }

    public function wishList(){
        $wishlist = $this->hasOne(Wishlist::class,'seller_product_id','id')->where('type', 'product');
        $user_id = 0;
        if(auth()->check()){
            $user_id = auth()->id();
        } 


        $wishlist = $wishlist->where('user_id', $user_id);

        return $wishlist;
    }

    public function scopeTotalProducts($query)
    {
        $seller_id = getParentSellerId();
        return $query->with('product', 'skus')->where('user_id', $seller_id)->get()->count();
        
    }

    public function scopeTopSaleProducts($query)
    {
        $seller_id = getParentSellerId();
        return $query->with('product', 'skus')->where('user_id', $seller_id)->orderBy('total_sale', 'desc')->take(10)->get();
    }

    public function scopeLatestUploadedProducts($query)
    {
        $seller_id = getParentSellerId();
        return $query->with('product', 'skus')->where('user_id', $seller_id)->latest()->take(10)->get();
    }


    public function getMenuElementsAttribute()
    {
        return MenuElement::where('type', 'product')->where('element_id', $this->id)->get();
    }

    public function headerProductPanel()
    {
        return $this->belongsTo(HeaderProductPanel::class, 'product_id', 'id');
    }

    public function getSildersAttribute()
    {
        return HeaderSliderPanel::where('data_type', 'product')->where('data_id', $this->id)->get();
    }

    public function homepageCustomProducts()
    {
        return $this->hasMany(HomepageCustomProduct::class, 'seller_product_id', 'id');
    }

    public function getOrdersAttribute()
    {
        return OrderProductDetail::where('type', 'product')->whereHas('seller_product_sku', function ($query) {
            $query->whereHas('product', function ($q) {
                $q->where('id', $this->id);
            });
        })->get();
    }

    public function getProductTypeAttribute(){
        return 'product';
    }
}
