<?php

namespace Modules\FrontendCMS\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Account\Entities\Transaction;
use Modules\Wallet\Entities\BankPayment;

class SubsciptionPaymentInfo extends Model
{
    use HasFactory;
    protected $table = 'subscription_payment_info';
    protected $guarded = ['id'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id')->withDefault();
    }

    public function item_details()
    {
        return $this->morphOne(BankPayment::class, 'itemable');
    }
}
