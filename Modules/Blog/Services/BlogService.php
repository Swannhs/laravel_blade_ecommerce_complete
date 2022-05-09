<?php

namespace Modules\Blog\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Blog\Repositories\BlogRepository;

class BlogService
{
    protected $blogRepository;

    public function __construct(BlogRepository  $blogRepository)
    {
        $this->blogRepository= $blogRepository;
    }

    public function getPosts()
    {
        return $this->blogRepository->getPosts();
    }
    public function postsWithQuery($query)
    {
        return $this->blogRepository->postsWithQuery($query);
    }
    public function categoryPost()
    {
        return $this->blogRepository->categoryPost();
    }
    public function categoryPostWithId($id)
    {
        return $this->blogRepository->categoryPostWithId($id);
    }
    public function popularPost()
    {
        return $this->blogRepository->popularPost();
    }
    public function postWithSlug($slug)
    {
        return $this->blogRepository->postWithSlug($slug);
    }
    public function likePost($id){
    	return $this->blogRepository->likePost($id);
    }
    public function checkPostLike($post_id){
    	return $this->blogRepository->checkPostLike($post_id);
    }
    public function deletePostLike($id)
    {
        return $this->blogRepository->deletePostLike($id);
    }
    public function createPostLike(array $data)
    {
        return $this->blogRepository->createPostLike($data);
    }

    public function createComment(array $data)
    {
        return $this->blogRepository->createComment($data);
    }
    public function createCommentReplay(array $data)
    {
        return $this->blogRepository->createCommentReplay($data);
    }
    

   

}

