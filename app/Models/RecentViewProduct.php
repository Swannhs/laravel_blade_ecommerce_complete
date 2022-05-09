<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Seller\Entities\SellerProduct;
use App\Models\User;

class RecentViewProduct extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function sellerProduct()
    {
        return $this->belongsTo(SellerProduct::class,'seller_product_id','id')->activeSeller()->withDefault();
    }

    public function customer()
    {
        return $this->belongsTo(User::class,'user_id','id')->withDefault();
    }
}
