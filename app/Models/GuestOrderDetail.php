<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Setup\Entities\City;
use Modules\Setup\Entities\Country;
use Modules\Setup\Entities\State;

class GuestOrderDetail extends Model
{
    use HasFactory;
    protected $table = "guest_order_details";
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id')->withDefault();
    }

    public function getBillingCountry()
    {
        return $this->belongsTo(Country::class,'billing_country_id','id')->withDefault();
    }

    public function getBillingState()
    {
        return $this->belongsTo(State::class,'billing_state_id','id')->withDefault();
    }

    public function getBillingCity()
    {
        return $this->belongsTo(City::class,'billing_city_id','id')->withDefault();
    }

    public function getShippingCountry()
    {
        return $this->belongsTo(Country::class,'shipping_country_id','id')->withDefault();
    }

    public function getShippingState()
    {
        return $this->belongsTo(State::class,'shipping_state_id','id')->withDefault();
    }

    public function getShippingCity()
    {
        return $this->belongsTo(City::class,'shipping_city_id','id')->withDefault();
    }
}
