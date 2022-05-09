<?php

namespace Modules\Refund\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\Refund\Entities\RefundReason;

class RefundProduct extends Model
{
    use HasFactory;
    protected $table = 'refund_products';
    protected $guarded = ['id'];

    public function seller_product_sku()
    {
        return $this->belongsTo(SellerProductSKU::class, 'seller_product_sku_id', 'id');
    }

    public function refund_reason()
    {
        return $this->belongsTo(RefundReason::class, 'refund_reason_id', 'id');
    }
}
