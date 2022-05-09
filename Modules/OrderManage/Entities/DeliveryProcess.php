<?php

namespace Modules\OrderManage\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\GeneralSetting\Entities\EmailTemplate;

class DeliveryProcess extends Model
{
    use HasFactory;
    protected $table = "delivery_processes";
    protected $guarded = ['id'];

    public function email_templates()
    {
        return $this->morphMany(EmailTemplate::class, 'relatable');
    }
}
