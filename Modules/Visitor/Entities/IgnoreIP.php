<?php

namespace Modules\Visitor\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IgnoreIP extends Model
{
    use HasFactory;
    protected $table = "ignore_ip";
    protected $guarded = [];
}
