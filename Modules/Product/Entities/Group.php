<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    

    public function category(){

        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function categories(){

        return $this->belongsToMany(Category::class,'category_group');
    }

    
    
}
