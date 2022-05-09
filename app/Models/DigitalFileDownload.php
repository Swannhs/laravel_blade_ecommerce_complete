<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\Product\Entities\ProductSku;
use Modules\Product\Entities\DigitalFile;

class DigitalFileDownload extends Model
{
    use HasFactory;
    protected $table = "digital_file_downloads";
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(User::class,'customer_id','id')->withDefault();
    }

    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id','id')->withDefault();
    }

    public function file()
    {
        return $this->hasOne(DigitalFile::class,'product_sku_id','product_sku_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id')->withDefault();
    }

    public function order_package()
    {
        return $this->belongsTo(OrderPackageDetail::class,'package_id','id')->withDefault();
    }

    public function seller_product_sku()
    {
        return $this->belongsTo(SellerProductSKU::class, 'seller_product_sku_id', 'id')->withDefault();
    }

    public function product_sku()
    {
        return $this->belongsTo(ProductSku::class, 'product_sku_id', 'id')->withDefault();
    }
}
