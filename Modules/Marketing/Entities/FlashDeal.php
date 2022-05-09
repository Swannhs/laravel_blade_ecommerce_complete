<?php

namespace Modules\Marketing\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class FlashDeal extends Model
{
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
    }
    protected $guarded = ['id'];
    
    public function products(){
        return $this->hasMany(FlashDealProduct::class,'flash_deal_id','id');
    }

    public function getAllProductsAttribute(){

        return FlashDealProduct::with('product.product')->where('flash_deal_id', $this->id)->latest()->paginate(10);
    }

    
    
}
