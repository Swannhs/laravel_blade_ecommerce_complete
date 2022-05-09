<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return \Modules\Blog\Database\factories\BlogCategoryFactory::new();
    }

    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            $model->slug = strtolower(str_replace(' ', '-', $model->name).'-'.$model->id);
            $model->save();
        });
        static::updating(function ($model) {
            $model->slug = strtolower(str_replace(' ', '-', $model->name).'-'.$model->id);
        });
    }

    public function childs(){
    	return $this->hasMany(BlogCategory::class,'parent_id','id')->with('categories');
    }

    public function parent(){
    	return $this->belongsTo(BlogCategory::class,'parent_id');
    }


    public function categories()
    {
    return $this->hasMany(BlogCategory::class, "parent_id", "id");
    }


    public function posts()
    {
        return $this->belongsToMany(BlogPost::class,'blog_category_post','blog_category_id','blog_post_id');
    }

    public function activePost()
    {
        return $this->belongsToMany(BlogPost::class,'blog_category_post','blog_category_id','blog_post_id')->where('is_approved',1);
    }


}
