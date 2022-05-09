<?php

namespace Modules\GiftCard\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Order;

class GiftCardUse extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id')->withDefault();
    }

    public function giftCard()
    {
        return $this->belongsTo(GiftCard::class,'gift_card_id','id')->withDefault();
    }
}
