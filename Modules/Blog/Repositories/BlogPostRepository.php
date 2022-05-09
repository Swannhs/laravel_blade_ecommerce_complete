<?php

namespace Modules\Blog\Repositories;
use Modules\Blog\Entities\BlogPost;
use Modules\Blog\Entities\BlogCategory;
use Modules\Blog\Entities\BlogTag;
use Auth;
use Modules\Setup\Entities\Tag;

class BlogPostRepository
{
    public function getAll()
    {
        return BlogPost::latest();
    }
    public function getUserPost()
    {
        return BlogPost::where('author_id',auth()->user()->id)->latest();
    }
    public function create(array $data)
    {
        return BlogPost::create($data);
    }

    public function find($id)
    {
        return BlogPost::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        return BlogPost::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return BlogPost::findOrFail($id)->delete();
    }

    public function statusUpdate($data, $id)
    {
        BlogPost::where('id',$id)->first()->update([
            'status' => $data['status']
        ]);
        return true;
    }

    public function approvalUpdate($data, $id){

        return BlogPost::where('id',$id)->update([
            'is_approved' => $data['is_approved'],
            'approved_by' => $data['approved_by']
        ]);
    }

    public function categoryList(){
        return BlogCategory::all();
    }
    public function tagList(){
        return Tag::limit(10)->get();
    }
    public  function categoryParentList(){
        return BlogCategory::where('parent_id',0)->get();
    }
    public function findWithRelModal($id){
        return BlogPost::where('id',$id)->with(['categories','tags','user'])->first();
    }
    public function isTag($tagSlug){
        return BlogTag::with('posts')->where('name', trim($tagSlug))->first();
    }
    public function deletePostImg($id){
        $post = BlogPost::where('id',$id)->firstOrFail();
        if(file_exists($post->image_url)){
            unlink(public_path($post->image_url));
        }
        $post->update([
            'image_url' => null
        ]);

        return true;
    }


}
