<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogComment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return \Modules\Blog\Database\factories\BlogCommentFactory::new();
    }

    public function commentUser(){

    	return $this->belongsTo(\App\Models\User::class,'user_id');
    }

    public function replay(){

    	return $this->hasMany(BlogCommentReplay::class,'blog_comment_id')->where('replay_id',0);
    }

    public function reReplay($id){
       return $this->hasMany(BlogCommentReplay::class,'blog_comment_id')->where('replay_id',$id);
    }

}
