<?php

namespace Modules\Blog\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Blog\Repositories\BlogCategoryRepository;

class BlogCategoryService
{
    protected $blogCategoryRepository;

    public function __construct(BlogCategoryRepository  $blogCategoryRepository)
    {
        $this->blogCategoryRepository= $blogCategoryRepository;
    }

    public function getAll()
    {
        return $this->blogCategoryRepository->getAll();
    }

    public function create(array $data)
    {
        return $this->blogCategoryRepository->create($data);
    }

    public function find($id)
    {   

        return $this->blogCategoryRepository->find($id);
       
    }

    public function update(array $data, $id)
    {
        return $this->blogCategoryRepository->update($data,$id);
    }

    public function delete($id)
    {
        return $this->blogCategoryRepository->delete($id);
    }

}
