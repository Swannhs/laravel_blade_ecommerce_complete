<?php


namespace Modules\Account\Observers;


use Illuminate\Support\Facades\Auth;
use Modules\Account\Entities\Transaction;

class TransactionsObserver
{
    public function creating(Transaction $transaction)
    {
        $transaction->created_by = Auth::id();
    }

    public function updating(Transaction $transaction)
    {
        $transaction->updated_by = Auth::id();
    }
}
