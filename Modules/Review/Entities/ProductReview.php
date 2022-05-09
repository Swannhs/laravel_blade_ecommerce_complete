<?php

namespace Modules\Review\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Seller\Entities\SellerProduct;
use Carbon\Carbon;
use Modules\GiftCard\Entities\GiftCard;

class ProductReview extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function customer(){
        return $this->belongsTo(User::class,'customer_id','id');
    }
    public function images(){
        return $this->hasMany(ReviewImage::class,'review_id','id');
    }
    public function product(){
        return $this->belongsTo(SellerProduct::class,'product_id','id');
    }

    public function giftcard(){
        return $this->belongsTo(GiftCard::class,'product_id', 'id');
    }

    public function reply(){
        return $this->hasOne(ReviewReply::class,'review_id','id');
    }
    public function seller(){
        return $this->belongsTo(User::class,'seller_id','id');
    }

    public function scopeTotalReviewCount($query, $type)
    {
        $year = Carbon::now()->year;
        if ($type == "today") {
            return $query->whereBetween('created_at', [Carbon::now()->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->get()->sum('grand_total');
        }
        if ($type == "week") {
            return $query->whereBetween('created_at', [Carbon::now()->subDays(7)->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->get()->sum('grand_total');
        }
        if ($type == "month") {
            $month = Carbon::now()->month;
            $date_1 = Carbon::create($year, $month)->startOfMonth()->format('Y-m-d')." 00:00:00";
            return $query->whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"])->get()->sum('grand_total');
        }
        if ($type == "year") {
            $date_1 = Carbon::create($year, 1)->startOfMonth()->format('Y-m-d')." 00:00:00";
            return $query->whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"])->get()->sum('grand_total');
        }

    }
}
