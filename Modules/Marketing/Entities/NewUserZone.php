<?php

namespace Modules\Marketing\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class NewUserZone extends Model
{
    use HasFactory;

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
    protected $guarded = ['id'];
    
    public function products(){
        return $this->hasMany(NewUserZoneProduct::class,'new_user_zone_id','id')->with('product.product');
    }

    public function categories(){
        return $this->hasMany(NewUserZoneCategory::class,'new_user_zone_id','id')->orderBy('position');
    }

    public function coupon(){
        return $this->hasOne(NewUserZoneCoupon::class,'new_user_zone_id','id');
    }
    public function couponCategories(){
        return $this->hasMany(NewUserZoneCouponCategory::class,'new_user_zone_id', 'id')->orderBy('position');
    }

    public function getAllProductsAttribute(){
        return NewUserZoneProduct::with('product.product')->where('new_user_zone_id', $this->id)->latest()->paginate(10);
    }
}
