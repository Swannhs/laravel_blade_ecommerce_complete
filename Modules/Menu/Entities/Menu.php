<?php

namespace Modules\Menu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Menu extends Model
{
    use HasFactory;

    protected $guarded = [''];
    
    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if ($model->created_by == null) {
                $model->created_by = Auth::user()->id ?? null;
            }
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id ?? null;
        });

        self::created(function ($model) {
            Cache::forget('MegaMenu');
        });
        self::updated(function ($model) {
            Cache::forget('MegaMenu');
        });
        self::deleted(function ($model) {
            Cache::forget('MegaMenu');
        });
    }

    public function columns(){
        return $this->hasMany(MenuColumn::class,'menu_id','id')->orderBy('position');
    }

    public function allElements(){
        return $this->hasMany(MenuElement::class,'menu_id','id')->orderBy('position');
    }

    public function notUsedElement(){
        return $this->hasMany(MenuElement::class,'menu_id','id')->where('column_id',null)->orderBy('position');
    }

    public function elements(){
        return $this->hasMany(MenuElement::class,'menu_id','id')->where('parent_id',null)->orderBy('position');
    }

    public function menus(){
        return $this->hasMany(MultiMegaMenu::class,'multi_mega_menu_id','id')->orderBy('position');
    }

    public function rightPanelData(){
        return $this->hasMany(MegaMenuRightPanel::class,'menu_id','id')->orderBy('position');
    }

    public function bottomPanelData(){
        return $this->hasMany(MegaMenuBottomPanel::class,'menu_id','id')->orderBy('position');
    }
    
}
