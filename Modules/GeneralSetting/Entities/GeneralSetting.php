<?php

namespace Modules\GeneralSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Language\Entities\Language;
use Modules\GeneralSetting\Entities\Currency;
use Modules\GeneralSetting\Entities\DateFormat;
use Modules\GeneralSetting\Entities\TimeZone;

class GeneralSetting extends Model
{
    protected $guarded = ['id'];

     public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function dateFormat()
    {
        return $this->belongsTo(DateFormat::class);
    }

    public function timeZone()
    {
        return $this->belongsTo(TimeZone::class);
    }

}
