<?php

namespace Modules\Refund\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundReason extends Model
{
    use HasFactory;
    protected $table = "refund_reasons";
    protected $guarded = ["id"];
}
