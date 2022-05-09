<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalFile extends Model
{
    use HasFactory;
    protected $table = "digital_files";
    protected $guarded = ["id"];

    public function product_sku()
    {
        return $this->belongsTo(ProductSku::class);
    }
}
