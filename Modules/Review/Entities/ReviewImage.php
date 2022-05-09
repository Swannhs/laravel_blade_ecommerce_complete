<?php

namespace Modules\Review\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReviewImage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function review(){
        $this->belongsTo(ProductReview::class,'review_id','id');
    } 
    
}
