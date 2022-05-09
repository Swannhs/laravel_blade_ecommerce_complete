<?php

namespace Modules\Account\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Account\Entities\BankAccount;
use Modules\Account\Entities\ChartOfAccount;
use Modules\Account\Entities\Transaction;
use Modules\Account\Observers\BankAccountsObserver;
use Modules\Account\Observers\ChartOfAccountsObserver;
use Modules\Account\Observers\TransactionsObserver;

class ModelObserverProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    public function boot(){
        ChartOfAccount::observe(ChartOfAccountsObserver::class);
        Transaction::observe(TransactionsObserver::class);
        BankAccount::observe(BankAccountsObserver::class);
    }
}
