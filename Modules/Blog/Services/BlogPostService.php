<?php

namespace Modules\Blog\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Blog\Repositories\BlogPostRepository;

class BlogPostService
{
    protected $blogPostRepository;

    public function __construct(BlogPostRepository  $blogPostRepository)
    {
        $this->blogPostRepository= $blogPostRepository;
    }

    public function getAll()
    {
        return $this->blogPostRepository->getAll();
    }
    public function getUserPost()
    {
        return $this->blogPostRepository->getUserPost();
    }

    public function create(array $data)
    {
        return $this->blogPostRepository->create($data);
    }

    public function find($id)
    {   

        return $this->blogPostRepository->find($id);
       
    }

    public function update(array $data, $id)
    {
        return $this->blogPostRepository->update($data,$id);
    }

    public function delete($id)
    {
        return $this->blogPostRepository->delete($id);
    }

    public function statusUpdate(array $data, $id)
    {
        return $this->blogPostRepository->statusUpdate($data,$id);
    }

    public function approvalUpdate(array $data, $id)
    {
        return $this->blogPostRepository->approvalUpdate($data,$id);
    }

    public function categoryList(){
        return $this->blogPostRepository->categoryList();
    }
    
    public function tagList(){
        return $this->blogPostRepository->tagList();
    }
    public function categoryParentList(){
        return $this->blogPostRepository->categoryParentList();
    }
    public function findWithRelModal($id){
        return $this->blogPostRepository->findWithRelModal($id);
    }
    public function isTag($tagSlug){
        return $this->blogPostRepository->isTag($tagSlug);
    }
    public function deletePostImg($id){
        return $this->blogPostRepository->deletePostImg($id);
    }


}
