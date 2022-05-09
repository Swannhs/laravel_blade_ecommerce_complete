<?php

namespace Modules\UserActivityLog\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LogActivity extends Model
{
    protected $table = 'log_activity';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
