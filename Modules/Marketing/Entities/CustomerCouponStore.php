<?php

namespace Modules\Marketing\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerCouponStore extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function coupon(){
        return $this->belongsTo(Coupon::class,'coupon_id','id');
    }
    public function customer(){
        return $this->belongsTo(User::class,'customer_id','id');
    }
}
