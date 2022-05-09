<?php

namespace Modules\Shipping\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;

class ProductShipping extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function shippingMethod(){
        return $this->belongsTo(ShippingMethod::class,'shipping_method_id','id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
