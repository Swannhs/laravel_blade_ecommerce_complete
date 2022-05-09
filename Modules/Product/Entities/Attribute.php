<?php
namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Attribute extends Model
{
    use HasFactory;
    protected $table = "attributes";
    protected $guarded = ["id"];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public static function boot()
    {
        parent::boot();
        static::created(function ($attribute) {
            $attribute->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($attribute) {
            $attribute->updated_by = Auth::user()->id ?? null;
        });
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
