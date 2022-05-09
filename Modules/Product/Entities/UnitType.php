<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UnitType extends Model
{
    protected $table = "unit_types";
    protected $guarded = ["id"];

    public static function boot()
    {
        parent::boot();
        static::created(function ($unit_type) {
            $unit_type->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($unit_type) {
            $unit_type->updated_by = Auth::user()->id ?? null;
        });
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function products()
    {
        return $this->hasMany(Product::class,'unit_type_id','id');
    }
}
