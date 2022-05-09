<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Seller\Entities\SellerProduct;

class ProductCrossSale extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function cross_seller_products(){
        return $this->hasMany(SellerProduct::class,'product_id','cross_sale_product_id')->activeSeller();
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id')->withDefault();
    }

    public function main_product()
    {
        return $this->belongsTo(Product::class,'cross_sale_product_id')->withDefault();
    }
}
