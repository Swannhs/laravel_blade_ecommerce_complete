<?php

namespace Modules\Marketing\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Coupon extends Model
{
    protected $guarded = ['id'];
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

    public function products(){
        return $this->hasMany(CouponProduct::class,'coupon_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function coupon_uses(){
        return $this->hasMany(CouponUse::class,'coupon_id','id');
    }

}
