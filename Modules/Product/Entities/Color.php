<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $table = "colors";
    protected $guarded = ["id"];

    public function attribute_value()
    {
        return $this->belongsTo(AttributeValue::class);
    }
}
