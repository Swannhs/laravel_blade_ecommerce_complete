<?php

namespace Modules\Appearance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Header extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            Cache::forget('HeaderSection');
            Cache::forget('productSectionItems');
        });
        self::updated(function ($model) {
            Cache::forget('HeaderSection');
            Cache::forget('productSectionItems');
        });
        self::deleted(function ($model) {
            Cache::forget('HeaderSection');
            Cache::forget('productSectionItems');
        });
    }    
    
    public function categorySectionItems(){
        return HeaderCategoryPanel::with('category.categoryImage')->orderBy('position')->whereHas('category', function($query){
            $query->where('status', 1);
        })->get();
    }

    public function productSectionItems(){
        return Cache::rememberForever('productSectionItems', function(){
            return HeaderProductPanel::with('product.product','product.skus')->orderBy('position')->whereHas('product', function($query){
                $query->where('status', 1)->whereHas('product', function($query){
                    $query->where('status', 1);
                })->activeSeller();
            })->get();
        });
        
    }

    public function newUserZonePanel(){
        
        return HeaderNewUserZonePanel::with('newUserZone')->first();
    }

    public function sliderSectionItems(){
       
        return HeaderSliderPanel::orderBy('position')->get();
    }

    public function sliders(){
        
        return HeaderSliderPanel::with('category')->where('status', 1)->orderBy('position')->get();
    }
    
}
