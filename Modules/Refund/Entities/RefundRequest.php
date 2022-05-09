<?php

namespace Modules\Refund\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Order;
use Modules\Wallet\Entities\BankPayment;
use Modules\Shipping\Entities\ShippingMethod;
use Modules\Customer\Entities\CustomerAddress;
use Modules\Refund\Entities\RefundRequestDetail;

class RefundRequest extends Model
{
    use HasFactory;
    protected $table = 'refund_requests';
    protected $guarded = ['id'];
    protected $appends = ['CheckConfirmed'];

    public function bank_payments()
    {
        return $this->morphOne(BankPayment::class, 'itemable');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function shipping_gateway()
    {
        return $this->belongsTo(ShippingMethod::class, 'shipping_method_id')->withDefault();
    }

    public function pick_up_address_customer()
    {
        return $this->belongsTo(CustomerAddress::class, 'pick_up_address_id', 'id');
    }

    public function refund_details()
    {
        return $this->hasMany(RefundRequestDetail::class);
    }

    public function getCheckConfirmedAttribute()
    {
        if ($this->is_confirmed == 1) {
            return "Confirmed";
        }elseif ($this->is_confirmed == 2) {
            return "Cancelled";
        }else {
            return "Pending";
        }
    }
}
