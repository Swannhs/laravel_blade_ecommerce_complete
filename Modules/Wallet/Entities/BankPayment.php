<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class BankPayment extends Model
{
    use HasFactory;
    protected $table = 'bank_details';
    protected $guarded = ['id'];

    public function wallets()
    {
        return $this->morphMany(WalletBalance::class, 'walletable');
    }

    public function itemable()
    {
        return $this->morphTo();
    }
}
