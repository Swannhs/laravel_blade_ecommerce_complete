<?php

namespace Modules\Marketing\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Category;

class NewUserZoneCouponCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
