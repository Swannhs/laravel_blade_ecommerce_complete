<?php

namespace Modules\SupportTicket\Entities;

use App\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $table = 'support_tickets';
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(TicketCategory::class,'category_id','id')->withDefault();
    }

    public function priority()
    {
        return $this->belongsTo(TicketPriority::class,'priority_id','id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id')->withDefault();
    }

    public function assignUser()
    {
        return $this->belongsTo(User::class,'refer_id','id')->withDefault();
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class,'ticket_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(TicketStatus::class,'status_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(TicketMessageFile::class,'message_id', 'id');
    }

    public function attachFiles()
    {
        return $this->morphMany(SupportTicketFile::class, 'attachment');
    }

}
