<?php

namespace Modules\GST\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class GstTax extends Model
{
    use HasFactory;
    protected $table = "gst_taxes";
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            $model->created_by = Auth::user()->id ?? null;
            $model->save();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id ?? null;
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function gst_taxes(){
        return $this->hasMany(OrderPackageGST::class,'gst_id','id');
    }
}
