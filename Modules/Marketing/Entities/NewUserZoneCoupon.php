<?php

namespace Modules\Marketing\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewUserZoneCoupon extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function newUserZone(){
        return $this->belongsTo(newUserZone::class,'new_user_zone_id','id');
    }

    public function coupon(){
        return $this->belongsTo(Coupon::class,'coupon_id','id');
    }
}
