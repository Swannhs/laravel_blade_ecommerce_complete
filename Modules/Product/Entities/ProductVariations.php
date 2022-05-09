<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductVariations extends Model
{
    protected $table = "product_variations";
    protected $guarded = ["id"];

    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            $model->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id ?? null;
        });


    }
    public function product_sku()
    {
        return $this->belongsTo(ProductSku::class, "product_sku_id");
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function attribute_value()
    {
        return $this->belongsTo(AttributeValue::class);
    }
}
