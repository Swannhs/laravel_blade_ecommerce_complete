<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    protected $fillable = [
        'name',
        'code',
        'opening_balance',
        'description',
        'default_for',
        'status',
        'type',
    ];

    public function parent()
    {
        return $this->belongsTo(ChartOfAccount::class, 'parent_id', 'id')->with('parent');
    }

    public function childs()
    {
        return $this->hasMany(ChartOfAccount::class, 'parent_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'chart_of_account_id', 'id');
    }

    public function getBalanceAttribute()
    {


        $in = $this->transactions()->where('type', 'in')->sum('amount');
        $out = $this->transactions()->where('type', 'out')->sum('amount');

        return $in - $out;
    }


}
