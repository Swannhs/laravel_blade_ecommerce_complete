<?php

namespace Modules\SupportTicket\Entities;

use Illuminate\Database\Eloquent\Model;

class TicketPriority extends Model
{
    protected $table  = 'support_ticket_pirority';
    protected $fillable = ['name','status'];
}
