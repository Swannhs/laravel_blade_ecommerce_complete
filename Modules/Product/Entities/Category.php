<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Modules\Affiliate\Entities\AffiliateCategoryCommission;
use Modules\Appearance\Entities\HeaderCategoryPanel;
use Modules\Appearance\Entities\HeaderSliderPanel;
use Modules\FrontendCMS\Entities\HomepageCustomCategory;
use Modules\Marketing\Entities\NewUserZoneCategory;
use Modules\Marketing\Entities\NewUserZoneCouponCategory;
use Modules\Menu\Entities\MegaMenuRightPanel;
use Modules\Menu\Entities\MenuElement;
use Modules\Seller\Entities\SellerProduct;

class Category extends Model
{
    use HasFactory;

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

    public function parentCategory(){

        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function groups(){

        return $this->hasMany(Group::class,'parent_id','id');
    }

    public function categoryImage(){

        return $this->hasOne(CategoryImage::class,'category_id','id')->withDefault();
    }

    public function brands(){

        return $this->belongsToMany(Brand::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('category_id', 'product_id');
    }

    public function getSellerProductCountAttribute(){
        $count = 0;
        foreach($this->products as $product){
            $count += $product->sellerProducts->count();
        }
        return $count;
    }


    public function sellerProducts(){

        $products = SellerProduct::with('product')->whereHas('product',function($query){
            return $query->whereHas('categories',function($q){
                $q->where('category_id',$this->id);
            })->where('status', 1);
        })->activeSeller()->take(6)->get();
        return $products;

    }

    public function sellerProductsAll(){
        return SellerProduct::where('status',1)->whereHas('product',function($query){
            return $query->whereHas('categories',function($q){
                $q->where('category_id', $this->id);
            });
        })->activeSeller()->get();

    }

    public function sellerProductWithPaginate(){
        $products = SellerProduct::with('product','reviews')->where('status',1)->whereHas('product',function($query){
            return $query->whereHas('categories',function($q){
                $q->where('category_id', $this->id);
            })->where('status', 1);
        })->activeSeller()->paginate(12);
        $products->appends([
            'item' => 'category',
            'category' => $this->id
        ]);
        return $products;
    }

    public function subCategories(){
        return $this->hasMany(Category::class,'parent_id','id');
    }

    public function newUserZoneCategories(){
        return $this->hasMany(NewUserZoneCategory::class,'category_id','id');
    }

    public function newUserZoneCouponCategories(){
        return $this->hasMany(NewUserZoneCouponCategory::class,'category_id','id');
    }

    public function getMenuElementsAttribute(){
        return MenuElement::where('type', 'category')->where('element_id', $this->id)->get();
    }

    public function getSildersAttribute(){
        return HeaderSliderPanel::where('data_type','category')->where('data_id', $this->id)->get();
    }

    public function headerCategoryPanel(){
        return $this->hasMany(HeaderCategoryPanel::class,'category_id', 'id');
    }

    public function MenuRightPanel(){
        return $this->hasMany(MegaMenuRightPanel::class,'category_id', 'id');
    }

    public function homepageCustomCategories(){
        return $this->hasMany(HomepageCustomCategory::class, 'category_id', 'id');
    }

    //for api
    public function getAllProductsAttribute(){
        return SellerProduct::with('product','reviews')->whereHas('product', function($query){
            return $query->whereHas('categories', function($q){
                $q->where('category_id', $this->id);
            })->where('status', 1);
        })->activeSeller()->where('status', 1)->paginate(10);
    }

    public function affiliateCategoryCommission()
    {
        return $this->hasOne(AffiliateCategoryCommission::class,'category_id');
    }



}
