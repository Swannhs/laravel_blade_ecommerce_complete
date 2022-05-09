<?php
namespace App\Repositories;

use Modules\Marketing\Entities\CustomerCouponStore;
use Modules\Marketing\Entities\NewUserZone;
use Modules\Marketing\Entities\NewUserZoneCategory;
use Modules\Marketing\Entities\NewUserZoneCouponCategory;
use Modules\Marketing\Entities\NewUserZoneProduct;
use Modules\Product\Entities\Category;
use Modules\Seller\Entities\SellerProduct;

class NewUserZoneRepository{

    public function getById($slug){

        return NewUserZone::with('products', 'categories', 'coupon', 'couponCategories', 'products.product.skus', 'categories.category', 'coupon.coupon','couponCategories.category')->where('slug',$slug)->firstOrFail();
    }

    public function getCategoryById($id){

        return NewUserZoneCategory::findOrFail($id);
    }
    public function getCouponCategoryById($id){

        return NewUserZoneCouponCategory::findOrFail($id);

    }

    public function getSellerProducts(){
        $products =  SellerProduct::where('status', 1)->activeSeller()->paginate(12);
        $products->appends([
            'item' => 'category'
        ]);
        return $products;
    }

    public function getAllProductsForCategories($slug){
        $new_user_zone = NewUserZone::where('slug', $slug)->first();
        $categories = Category::whereHas('newUserZoneCategories', function($query) use($new_user_zone){
            $query->where('new_user_zone_id', $new_user_zone->id);
        })->where('status', 1)->pluck('id');
        $products =  SellerProduct::with('product','reviews','wishList','skus')->where('status', 1)->whereHas('product', function($query) use($categories){
            $query->whereHas('categories', function($q1)use($categories){
                $q1->whereIn('category_id',$categories);
            })->where('status', 1);
        })->activeSeller()->paginate(12);
        $products->appends([
            'item' => 'category'
        ]);
        return $products;
    }

    public function getAllProductsForCouponCategories($slug){
        $new_user_zone = NewUserZone::where('slug', $slug)->first();
        $categories = Category::whereHas('newUserZoneCouponCategories', function($query) use($new_user_zone){
            $query->where('new_user_zone_id', $new_user_zone->id);
        })->where('status', 1)->pluck('id');
        $products =  SellerProduct::with('product','reviews','wishList','skus')->where('status', 1)->whereHas('product', function($query) use($categories){
            $query->whereHas('categories', function($q1)use($categories){
                $q1->whereIn('category_id',$categories);
            })->where('status', 1);
        })->activeSeller()->paginate(12);
        $products->appends([
            'item' => 'category'
        ]);
        return $products;
    }
    
    public function newUserZoneProducts($id){
        return NewUserZoneProduct::where('new_user_zone_id', $id)->get();
    }

    public function couponStore($data){
        return CustomerCouponStore::create([
            'coupon_id' => $data['coupon_id'],
            'customer_id' => auth()->user()->id
        ]);
    }
    
}