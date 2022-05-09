<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\FrontendCMS\Entities\SubsciptionPaymentInfo;
use Carbon\Carbon;

class Transaction extends Model
{
    protected $fillable = [
        'title',
        'type',
        'payment_method',
        'come_from',
        'morphable_id',
        'morphable_type',
        'chart_of_account_id',
        'amount',
        'transaction_date',
        'description',
        'bank_account_id',
    ];

    public function account()
    {
        return $this->belongsTo(ChartOfAccount::class, 'chart_of_account_id', 'id');
    }

    public function bank()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id', 'id');
    }

    public function subscription_payment()
    {
        return $this->hasOne(SubsciptionPaymentInfo::class, 'transaction_id', 'id')->withDefault();
    }

    public function morphable()
    {
        return $this->morphTo();
    }

    public function scopeGetIncome($query, $type)
    {
        $year = Carbon::now()->year;
        $query->where('type', 'in')->whereIn('come_from', ['sales_income','income','wallet_recharge','payroll_expense','installment_income','loan_expense']);
        if ($type == "today") {
            return $query->whereBetween('created_at', [Carbon::now()->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->get()->sum('amount');
        }
        if ($type == "week") {
            return $query->whereBetween('created_at', [Carbon::now()->subDays(7)->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->get()->sum('amount');
        }
        if ($type == "month") {
            $month = Carbon::now()->month;
            $date_1 = Carbon::create($year, $month)->startOfMonth()->format('Y-m-d')." 00:00:00";
            return $query->whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"])->get()->sum('amount');
        }
        if ($type == "year") {
            $date_1 = Carbon::create($year, 1)->startOfMonth()->format('Y-m-d')." 00:00:00";
            return $query->whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"])->get()->sum('amount');
        }

    }


    public function scopeGetExpense($query, $type)
    {
        $year = Carbon::now()->year;
        $query->where('type', 'out')->whereIn('come_from', ['sales_income','income','expense','wallet_recharge','payroll_expense','installment_income','loan_expense']);
        if ($type == "today") {
            return $query->whereBetween('created_at', [Carbon::now()->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->get()->sum('amount');
        }
        if ($type == "week") {
            return $query->whereBetween('created_at', [Carbon::now()->subDays(7)->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->get()->sum('amount');
        }
        if ($type == "month") {
            $month = Carbon::now()->month;
            $date_1 = Carbon::create($year, $month)->startOfMonth()->format('Y-m-d')." 00:00:00";
            return $query->whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"])->get()->sum('amount');
        }
        if ($type == "year") {
            $date_1 = Carbon::create($year, 1)->startOfMonth()->format('Y-m-d')." 00:00:00";
            return $query->whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"])->get()->sum('amount');
        }

    }
}
