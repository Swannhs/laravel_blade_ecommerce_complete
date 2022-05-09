<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogCommentReplay extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected static function newFactory()
    {
        return \Modules\Blog\Database\factories\BlogCommentReplayFactory::new();
    }

    public function replayUser(){

    	return $this->belongsTo(\App\Models\User::class,'user_id');
    }

    public function replayReplay(){
        return $this->hasMany(BlogCommentReplay::class,'replay_id');
    }
}
