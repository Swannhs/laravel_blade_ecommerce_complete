<?php

namespace Modules\GeneralSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmsGatewaySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'send_to_parameter_name',
        'message_parameter_name',
        'request_method',
        'parameter_1_key',
        'parameter_2_key',
        'parameter_3_key',
        'parameter_4_key',
        'parameter_5_key',
        'parameter_6_key',
        'parameter_7_key',
        'parameter_8_key',
        'parameter_9_key',
        'parameter_10_key',
        'parameter_1_value',
        'parameter_2_value',
        'parameter_3_value',
        'parameter_4_value',
        'parameter_5_value',
        'parameter_6_value',
        'parameter_7_value',
        'parameter_8_value',
        'parameter_9_value',
        'parameter_10_value',
    ];

}
