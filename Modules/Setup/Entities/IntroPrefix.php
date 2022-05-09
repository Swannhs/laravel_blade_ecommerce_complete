<?php

namespace Modules\Setup\Entities;

use Illuminate\Database\Eloquent\Model;

class IntroPrefix extends Model
{
    protected $table = 'intro_prefix';
    protected $guarded = ['id'];
}
