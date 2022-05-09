<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\Shipping\Entities\ShippingMethod;
use Modules\GiftCard\Entities\GiftCard;
use Carbon\Carbon;

class Cart extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(SellerProductSKU::class,'product_id','id');
    }
    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class,'shipping_method_id','id');
    }
    public function giftCard()
    {
        return $this->belongsTo(GiftCard::class,'product_id','id');
    }

    public function scopeTotalCart($query, $type)
    {
        $year = Carbon::now()->year;
        if ($type == "today") {
            return $query->whereBetween('created_at', [Carbon::now()->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->get()->count();
        }
        if ($type == "week") {
            return $query->whereBetween('created_at', [Carbon::now()->subDays(7)->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->get()->count();
        }
        if ($type == "month") {
            $month = Carbon::now()->month;
            $date_1 = Carbon::create($year, $month)->startOfMonth()->format('Y-m-d')." 00:00:00";
            return $query->whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"])->get()->count();
        }
        if ($type == "year") {
            $date_1 = Carbon::create($year, 1)->startOfMonth()->format('Y-m-d')." 00:00:00";
            return $query->whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"])->get()->count();
        }

    }

    public function seller(){
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    public function customer(){
        return $this->belongsTo(User::class,'user_id', 'id');
    }
}
