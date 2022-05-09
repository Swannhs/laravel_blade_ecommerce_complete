<?php

namespace Modules\Marketing\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CouponUse extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
}
