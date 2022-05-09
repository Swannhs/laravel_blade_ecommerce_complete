<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $guarded = ['id'];

    protected $fillable = ['bank_name','branch_name','account_name','account_number'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'bank_account_id', 'id');
    }

    public function getBalanceAttribute()
    {
        $in = $this->transactions()->where('type', 'in')->sum('amount');
        $out = $this->transactions()->where('type', 'out')->sum('amount');
        return $in - $out;
    }
}
