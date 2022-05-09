<?php

namespace Modules\FooterSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Modules\FrontendCMS\Entities\DynamicPage;

class FooterWidget extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('footerWidget');
        });
        self::updated(function ($model) {
            Cache::forget('footerWidget');
        });
        self::deleted(function($model){
            Cache::forget('footerWidget');
        });
    }
    
    public function pageData(){
        return $this->belongsTo(DynamicPage::class,'page', 'id');
    }
}
