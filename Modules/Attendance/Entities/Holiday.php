<?php

namespace Modules\Attendance\Entities;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $fillable = ['year','name','date','type'];
}
