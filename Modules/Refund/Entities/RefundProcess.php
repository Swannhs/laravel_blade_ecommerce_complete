<?php

namespace Modules\Refund\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\GeneralSetting\Entities\EmailTemplate;

class RefundProcess extends Model
{
    use HasFactory;
    protected $table = 'refund_processes';
    protected $guarded = ['id'];

    public function email_templates()
    {
        return $this->morphMany(EmailTemplate::class, 'relatable');
    }
}
