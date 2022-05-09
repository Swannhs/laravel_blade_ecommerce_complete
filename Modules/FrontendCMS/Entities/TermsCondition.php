<?php

namespace Modules\FrontendCMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TermsCondition extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'terms_conditions';
    
    protected static function newFactory()
    {
        return \Modules\FrontendCMS\Database\factories\TermsConditionFactory::new();
    }
}
