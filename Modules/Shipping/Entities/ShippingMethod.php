<?php

namespace Modules\Shipping\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ShippingMethod extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function request_user()
    {
        return $this->belongsTo(User::class,'request_by_user','id')->withDefault();
    }

    public function methodUse(){
        return $this->hasMany(ProductShipping::class,'shipping_method_id', 'id');
    }
}
