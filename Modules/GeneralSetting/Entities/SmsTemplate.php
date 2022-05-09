<?php

namespace Modules\GeneralSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmsTemplate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function templateType(){
        return $this->belongsTo(SmsTemplateType::class, 'type_id','id');
    }

    public function relatable()
    {
        return $this->morphTo();
    }
    
}
