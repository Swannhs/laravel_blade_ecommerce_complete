<?php

namespace Modules\InhouseOrder\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\Shipping\Entities\ShippingMethod;

class InhouseOrderCart extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    

    public function product()
    {
        return $this->belongsTo(SellerProductSKU::class,'product_id','id');
    }

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class,'shipping_method_id','id');
    }
    
}
