<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Seller\Entities\SellerProductSKU;

class Compare extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    

    public function sellerProductSKU(){
        return $this->belongsTo(SellerProductSKU::class, 'product_sku_id', 'id');
    }

    public function customer(){
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }
}
