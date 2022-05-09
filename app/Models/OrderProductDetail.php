<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\GiftCard\Entities\GiftCard;

class OrderProductDetail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function package(){
        return $this->belongsTo(OrderPackageDetail::class,'package_id','id');
    }

    public function seller_product_sku()
    {
        return $this->belongsTo(SellerProductSKU::class, 'product_sku_id', 'id');
    }

    public function giftCard()
    {
        return $this->belongsTo(GiftCard::class,'product_sku_id','id');
    }
}
