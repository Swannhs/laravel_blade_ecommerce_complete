<?php

namespace Modules\Refund\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundState extends Model
{
    use HasFactory;
    protected $table = 'refund_states';
    protected $guarded = ['id'];
}
