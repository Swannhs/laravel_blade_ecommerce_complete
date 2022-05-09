<?php

namespace Modules\Refund\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Refund\Entities\RefundProduct;
use App\Models\OrderPackageDetail;
use App\Models\User;
use Carbon\Carbon;

class RefundRequestDetail extends Model
{
    use HasFactory;
    protected $table = 'refund_request_details';
    protected $guarded = ['id'];
    protected $appends = ['ProcessState'];

    public function order_package()
    {
        return $this->belongsTo(OrderPackageDetail::class, 'order_package_id', 'id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    public function process_refund()
    {
        return $this->belongsTo(RefundProcess::class, 'processing_state', 'id');
    }

    public function refund_request()
    {
        return $this->belongsTo(RefundRequest::class, 'refund_request_id', 'id');
    }

    public function refund_products()
    {
        return $this->hasMany(RefundProduct::class);
    }

    public function getProcessStateAttribute()
    {
        if ($this->processing_state == 1) {
            return "Confirmed";
        }elseif ($this->processing_state == 2) {
            return "Processing";
        }elseif ($this->processing_state == 3) {
            return "Completed";
        }else {
            return "Pending";
        }
    }

    public function scopeLatestRequest($query)
    {
        $seller_id = getParentSellerId();
        return $query->with('refund_request','seller','refund_products','order_package')->where('seller_id', $seller_id)->latest()->take(10)->get();
    }

    public function scopeTotalRefundCount($query, $type)
    {
        $seller_id = getParentSellerId();
        $year = Carbon::now()->year;
        if ($type == "today") {
            $query->whereBetween('created_at', [Carbon::now()->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"]);
        }
        if ($type == "week") {
            $query->whereBetween('created_at', [Carbon::now()->subDays(7)->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"]);
        }
        if ($type == "month") {
            $month = Carbon::now()->month;
            $date_1 = Carbon::create($year, $month)->startOfMonth()->format('Y-m-d')." 00:00:00";
            $query->whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"]);
        }
        if ($type == "year") {
            $date_1 = Carbon::create($year, 1)->startOfMonth()->format('Y-m-d')." 00:00:00";
            $query->whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"]);
        }
        $refundRequestDetailsIds = $query->where('seller_id',$seller_id)->pluck('id');
        return RefundProduct::whereIn('refund_request_detail_id', $refundRequestDetailsIds)->sum('return_amount');
    }
}
