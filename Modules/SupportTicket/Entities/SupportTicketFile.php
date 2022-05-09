<?php

namespace Modules\SupportTicket\Entities;

use Illuminate\Database\Eloquent\Model;

class SupportTicketFile extends Model
{
    protected $guarded = [];

    public function attachment()
    {
    	return $this->morphTo();
    }
}
