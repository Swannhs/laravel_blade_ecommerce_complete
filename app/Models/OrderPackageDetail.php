<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\OrderManage\Entities\OrderDeliveryState;
use Modules\OrderManage\Entities\DeliveryProcess;
use Modules\Review\Entities\ProductReview;
use Modules\GST\Entities\OrderPackageGST;
use Modules\Shipping\Entities\ShippingMethod;
use Modules\OrderManage\Entities\CancelReason;
use App\Models\DigitalFileDownload;
use Carbon\Carbon;

class OrderPackageDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['deliveryStateName','totalGST','processes'];

    public function order(){
        return $this->belongsTo(Order::class,'order_id','id');
    }


    public function all_order(){
        return $this->belongsTo(Order::class,'order_id','id')->with('customer');;
    }

    public function completed_order(){
        return $this->belongsTo(Order::class,'order_id','id')->where('is_completed',1)->with('customer');
    }

    public function paid_order(){
        return $this->belongsTo(Order::class,'order_id','id')->where('is_paid',1)->with('customer');
    }

    public function confirmed_order(){
        return $this->belongsTo(Order::class,'order_id','id')->where('is_confirmed',1)->with('customer');
    }

    public function cancelled_order(){
        return $this->belongsTo(Order::class,'order_id','id')->where('is_cancelled',1)->with('customer');
    }

    public function cancel_reason()
    {
        return $this->belongsTo(CancelReason::class,'cancel_reason_id','id');
    }

    public function products(){
        return $this->hasMany(OrderProductDetail::class,'package_id','id');
    }

    public function files(){
        return $this->hasMany(DigitalFileDownload::class,'package_id','id');
    }

    public function shipping(){
        return $this->belongsTo(ShippingMethod::class,'shipping_method','id');
    }

    public function gst_taxes(){
        return $this->hasMany(OrderPackageGST::class,'package_id','id');
    }

    public function seller(){
        return $this->belongsTo(User::class,'seller_id','id');
    }

    public function delivery_process(){
        return $this->belongsTo(DeliveryProcess::class,'delivery_status','id');
    }

    public function delivery_states(){
        return $this->hasMany(OrderDeliveryState::class,'order_package_id');
    }

    public function getDeliveryStateNameAttribute()
    {
        if($this->delivery_status <= 1) {
            return "Pending";
        }
        if ($this->delivery_status == 2) {
            return "Processing";
        }elseif ($this->delivery_status == 3) {
            return "Shipped";
        }elseif ($this->delivery_status == 4) {
            return "Recieved";
        }elseif ($this->delivery_status >= 5) {
            return "Delivered";
        }

    }

    public function reviews(){
        return $this->hasMany(ProductReview::class,'package_id','id');
    }

    public function getTotalGSTAttribute(){
        return $this->gst_taxes->sum('amount');
    }

    public function getProcessesAttribute(){
        return DeliveryProcess::all();
    }

    public function scopeTotalOrders($query,$type)
    {
        if (auth()->user()->role->type == 'seller') {
            if(auth()->user()->sub_seller){
                $seller_id = auth()->user()->sub_seller->seller_id;
            }else{
                $seller_id = auth()->user()->id;
            }
            
        }else {
            $seller_id = auth()->user()->id;
        }
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
        return $query->with('order', 'seller', 'order.customer')->where('seller_id',$seller_id)->get()->count();
    }

    public function scopeTotalDeliveredOrders($query,$type,$state)
    {
        if (auth()->user()->role->type == 'seller') {
            if(auth()->user()->sub_seller){
                $seller_id = auth()->user()->sub_seller->seller_id;
            }else{
                $seller_id = auth()->user()->id;
            }
            
        }else {
            $seller_id = auth()->user()->id;
        }
        $year = Carbon::now()->year;
        if ($type == "today") {
            $query->whereBetween('updated_at', [Carbon::now()->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"]);
        }
        if ($type == "week") {
            $query->whereBetween('updated_at', [Carbon::now()->subDays(7)->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"]);
        }
        if ($type == "month") {
            $month = Carbon::now()->month;
            $date_1 = Carbon::create($year, $month)->startOfMonth()->format('Y-m-d')." 00:00:00";
            $query->whereBetween('updated_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"]);
        }
        if ($type == "year") {
            $date_1 = Carbon::create($year, 1)->startOfMonth()->format('Y-m-d')." 00:00:00";
            $query->whereBetween('updated_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"]);
        }
        if ($state == "delivered") {
            return $query->with('order', 'seller', 'order.customer')->where('seller_id',$seller_id)->where('delivery_status','>=',5)->get()->count();
        }
        else {
            return $query->with('order', 'seller', 'order.customer')->where('seller_id',$seller_id)->where('delivery_status','<',5)->get()->count();
        }
    }

    public function scopeLatestOrder($query)
    {
        if (auth()->user()->role->type == 'seller') {
            if(auth()->user()->sub_seller){
                $seller_id = auth()->user()->sub_seller->seller_id;
            }else{
                $seller_id = auth()->user()->id;
            }
            
        }else {
            $seller_id = auth()->user()->id;
        }
        return $query->with('order', 'seller', 'order.customer')->where('seller_id',$seller_id)->latest()->take(10)->get();
    }

    public function scopeTotalOtherIncome($query, $type)
    {
        if (auth()->user()->role->type == 'seller') {
            if(auth()->user()->sub_seller){
                $seller_id = auth()->user()->sub_seller->seller_id;
            }else{
                $seller_id = auth()->user()->id;
            }
            
        }else {
            $seller_id = auth()->user()->id;
        }
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
        $shipping_cost = $query->where('seller_id',$seller_id)->sum('shipping_cost');
        $tax_amount = $query->where('seller_id',$seller_id)->sum('tax_amount');
        $total = $shipping_cost + $tax_amount;
        $data['shipping_cost'] = $shipping_cost;
        $data['tax_amount'] = $tax_amount;
        $data['total'] = $total;
        return $data;
    }

    public function scopeNetTotalProductSaleAmount($query, $type)
    {
        if (auth()->user()->role->type == 'seller') {
            if(auth()->user()->sub_seller){
                $seller_id = auth()->user()->sub_seller->seller_id;
            }else{
                $seller_id = auth()->user()->id;
            }
            
        }else {
            $seller_id = auth()->user()->id;
        }
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
        $orderPackageIds = $query->where('seller_id',$seller_id)->pluck('id');
        return OrderProductDetail::whereIn('package_id', $orderPackageIds)->sum('total_price');
    }
}
