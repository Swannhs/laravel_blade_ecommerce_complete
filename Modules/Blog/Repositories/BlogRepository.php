<?php

namespace Modules\Blog\Repositories;

use Illuminate\Support\Facades\Auth;
use Modules\Blog\Entities\BlogPost;
use Modules\Blog\Entities\BlogCategory;
use Modules\Blog\Entities\BlogTag;
use Modules\Blog\Entities\BlogPostLike;
use Modules\Blog\Entities\BlogComment;
use Modules\Blog\Entities\BlogCommentReplay;

class BlogRepository
{
    public function getPosts()
    {
        return BlogPost::latest()->approved()->published()->paginate(5);
    }
    public function postsWithQuery($query){
    	return BlogPost::where('title','LIKE',"%$query%")->latest()->approved()->published()->paginate(5);
    }
    public function categoryPost(){
    	return BlogCategory::withCount('activePost')->get();
    }
    public function categoryPostWithId($slug){
    	return BlogCategory::with('posts')->where('slug',$slug)->get();
    }
    public function popularPost(){
    	return BlogPost::withCount('likePost')->where('is_approved',1)->orderBy('like_post_count','desc')->take(5)->get();
    }
    public function postWithSlug($slug){
    	return BlogPost::where('slug',$slug)->where('status',1)->with(['comments.commentUser','comments.replay.replayReplay','comments.replay'])->firstOrFail();
    }
    public function likePost($id){
    	return BlogPost::where('id',$id)->withCount('like')->first();
    }
    public function checkPostLike($post_id){
    	return BlogPostLike::where(['user_id'=>Auth::id(),'post_id'=>$post_id])->first();
    }
    public function deletePostLike($id)
    {
        return BlogPostLike::findOrFail($id)->delete();
    }
    public function createPostLike(array $data)
    {
        return BlogPostLike::create($data);
    }
    public function createComment(array $data)
    {
        return BlogComment::create($data);
    }
    public function createCommentReplay(array $data)
    {
        return BlogCommentReplay::create($data);
    }



}
