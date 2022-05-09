<?php

namespace Modules\FrontendCMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Modules\FooterSetting\Entities\FooterWidget;
use Modules\Menu\Entities\MenuElement;

class DynamicPage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('footerWidget');
            Cache::forget('MegaMenu');
            Cache::forget('HeaderSection');
        });
        self::updated(function ($model) {
            Cache::forget('footerWidget');
            Cache::forget('MegaMenu');
            Cache::forget('HeaderSection');
        });
        self::deleted(function ($model) {
            Cache::forget('footerWidget');
            Cache::forget('MegaMenu');
            Cache::forget('HeaderSection');
        });
    }

    public function getMenuElementsAttribute(){
        return MenuElement::where('type', 'page')->where('element_id', $this->id)->get();
    }

    public function footerWidgets(){
        return $this->hasMany(FooterWidget::class,'page', 'id');
    }
    
    
}
