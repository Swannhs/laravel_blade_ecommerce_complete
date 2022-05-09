<?php

namespace App\Traits;
use Modules\Account\Entities\ChartOfAccount;
use Modules\Setup\Entities\Tax;

trait Accounts
{
    public function defaultIncomeAccount()
    {
        $chart_account = ChartOfAccount::where('default_for', 'Income')->where('status', 1)->first();
        if ($chart_account) {
            return $chart_account->id;
        }
        return null;
    }

    public function defaultGSTAccount()
    {
        $chart_account = ChartOfAccount::where('default_for', 'GST Tax Account')->where('status', 1)->first();
        if ($chart_account) {
            return $chart_account->id;
        }
        return null;
    }

    public function defaultSellerAccount()
    {
        $chart_account = ChartOfAccount::where('default_for', 'Seller Account')->where('status', 1)->first();
        if ($chart_account) {
            return $chart_account->id;
        }
        return null;
    }

    public function defaultSallaryAccount()
    {
        $chart_account = ChartOfAccount::where('default_for', 'Sallary Account')->where('status', 1)->first();
        if ($chart_account) {
            return $chart_account->id;
        }
        return null;
    }

    public function defaultProductTaxAccount()
    {
        $chart_account = ChartOfAccount::where('default_for', 'Product Wise Tax Account')->where('status', 1)->first();
        if ($chart_account) {
            return $chart_account->id;
        }
        return null;
    }

    public function defaultExpenseAccount()
    {
        $chart_account = ChartOfAccount::where('default_for', 'Expense')->where('status', 1)->first();
        if ($chart_account) {
            return $chart_account->id;
        }
        return null;
    }

    public function defaultLiabilityAccount()
    {
        $chart_account = ChartOfAccount::where('default_for', 'Liability')->where('status', 1)->first();
        if ($chart_account) {
            return $chart_account->id;
        }
        return null;
    }

    public function getAccountId($user_id)
    {
        return ChartOfAccount::where('user_id', $user_id)->first()->id;
    }
}
