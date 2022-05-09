<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogPostLike extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected static function newFactory()
    {
        return \Modules\Blog\Database\factories\BlogPostLikeFactory::new();
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
}
