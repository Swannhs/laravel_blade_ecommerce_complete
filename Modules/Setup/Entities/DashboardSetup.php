<?php

namespace Modules\Setup\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardSetup extends Model
{
    use HasFactory;
    protected $table = "dashboard_setup";
    protected $guarded = ['id'];
}
