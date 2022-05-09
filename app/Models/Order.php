<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Wallet\Entities\WalletBalance;
use Modules\Customer\Entities\CustomerAddress;
use Modules\Marketing\Entities\CouponUse;
use Modules\GST\Entities\OrderPackageGST;
use Modules\GiftCard\Entities\GiftCardUse;
use Modules\OrderManage\Entities\CancelReason;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer(){
        return $this->belongsTo(User::class,'customer_id','id');
    }

    public function cancel_reason(){
        return $this->belongsTo(CancelReason::class,'cancel_reason_id','id');
    }

    public function packages(){
        return $this->hasMany(OrderPackageDetail::class,'order_id','id');
    }

    public function gift_card_uses(){
        return $this->hasMany(GiftCardUse::class,'order_id','id');
    }

    public function guest_info()
    {
        return $this->hasOne(GuestOrderDetail::class,'order_id','id');
    }

    public function order_payment(){
        return $this->belongsTo(OrderPayment::class,'order_payment_id', 'id');
    }

    public function shipping_address(){
        return $this->belongsTo(CustomerAddress::class, 'customer_shipping_address','id');
    }

    public function billing_address(){
        return $this->belongsTo(CustomerAddress::class, 'customer_billing_address','id');
    }

    public function wallets()
    {
        return $this->morphMany(WalletBalance::class, 'walletable');
    }
    public function coupon(){
        return $this->hasOne(CouponUse::class,'order_id','id');
    }

    public function getGatewayNameAttribute()
    {
        switch ($this->payment_type) {
            case '1':
                return "Cash On Delivery";
                break;
            case '2':
                return "Wallet";
                break;
            case '3':
                return "PayPal";
                break;
            case '4':
                return "Stripe";
                break;
            case '5':
                return "PayStack";
                break;
            case '6':
                return "RazorPay";
                break;
            case '7':
                return "Bank Payment";
                break;
            case '8':
                return "Instamojo";
                break;
            case '9':
                return "PayTM";
                break;
            case '10':
                return "Midtrans";
                break;
            case '11':
                return "PayUMoney";
                break;
            case '12':
                return "JazzCash";
                break;
            case '13':
                return "Google Pay";
                break;
            case '14':
                return "FlutterWave";
                break;
            default:
                return "N/A";
                break;
        }
    }

    public function getTotalGstAmountAttribute()
    {
        $order_id = $this->id;
        return OrderPackageGST::whereHas('order_package', function($q) use($order_id){
            $q->where('order_id', $order_id);
        })->get()->sum('amount');
    }

    public function scopeTotalSaleCount($query, $type)
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

    public function scopeOrderInfo($query, $type, $state)
    {
        $year = Carbon::now()->year;
        if ($type == "today") {
            $query->whereBetween('created_at', [Carbon::now()->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->get()->count();
        }
        if ($type == "week") {
            $query->whereBetween('created_at', [Carbon::now()->subDays(7)->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->get()->count();
        }
        if ($type == "month") {
            $month = Carbon::now()->month;
            $date_1 = Carbon::create($year, $month)->startOfMonth()->format('Y-m-d')." 00:00:00";
            $query->whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"])->get()->count();
        }
        if ($type == "year") {
            $date_1 = Carbon::create($year, 1)->startOfMonth()->format('Y-m-d')." 00:00:00";
            $query->whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"])->get()->count();
        }
        if ($state == "all") {
            return $query->get()->count();
        }
        if ($state == 0) {
            return $query->where('is_confirmed', 0)->get()->count();
        }
        if ($state == 1) {
            return $query->where('is_completed', 1)->get()->count();
        }

    }
}
