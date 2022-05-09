<?php

namespace Modules\GeneralSetting\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplateType extends Model
{
    use HasFactory;
    protected $fillable=['type'];
}
