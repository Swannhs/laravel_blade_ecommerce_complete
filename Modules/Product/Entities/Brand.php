<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Modules\Appearance\Entities\HeaderSliderPanel;
use Modules\FrontendCMS\Entities\HomepageCustomBrand;
use Modules\Menu\Entities\MegaMenuBottomPanel;
use Modules\Menu\Entities\MenuElement;
use Modules\Seller\Entities\SellerProduct;

class Brand extends Model
{
    protected $table = "brands";
    protected $guarded = ["id"];

    public static function boot()
    {
        parent::boot();
        static::created(function ($brand) {
            $brand->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($brand) {
            $brand->updated_by = Auth::user()->id ?? null;
        });

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


    public function products(){
        return $this->hasMany(Product::class,'brand_id','id');
    }

    public function sellerProductsAll(){
        return SellerProduct::where('status',1)->whereHas('product',function($query){
            return $query->where('brand_id',$this->id);
        })->activeSeller()->get();

    }
    
    public function getMenuElementsAttribute(){
        return MenuElement::where('type', 'brand')->where('element_id', $this->id)->get();
    }

    public function MenuBottomPanel(){
        return $this->hasMany(MegaMenuBottomPanel::class,'brand_id', 'id');
    }

    public function getSildersAttribute(){
        return HeaderSliderPanel::where('data_type','brand')->where('data_id', $this->id)->get();
    }

    public function homepageCustomBrands(){
        return $this->hasMany(HomepageCustomBrand::class, 'brand_id', 'id');
    }

    //for api
    public function getAllProductsAttribute(){
        return SellerProduct::with('product')->whereHas('product', function($query){
            return $query->where('brand_id', $this->id);
        })->activeSeller()->paginate(10);
    }
    

}
