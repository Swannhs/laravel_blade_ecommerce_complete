<?php

namespace Modules\SupportTicket\Entities;

use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    protected $table  = 'support_ticket_category';
    protected $fillable = ['name','status'];
}
