<?php

namespace Modules\GeneralSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function email_template_type()
    {
        return $this->belongsTo(EmailTemplateType::class,'type_id','id')->withDefault();
    }

    public function relatable()
    {
        return $this->morphTo();
    }

}
