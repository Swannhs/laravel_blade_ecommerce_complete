<?php

namespace Modules\Blog\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Blog\Repositories\BlogTagRepository;

class BlogTagService
{
    protected $blogTagRepository;

    public function __construct(BlogTagRepository  $blogTagRepository)
    {
        $this->blogTagRepository= $blogTagRepository;
    }

    public function getAll()
    {
        return $this->blogTagRepository->getAll();
    }

    public function create(array $data)
    {
        return $this->blogTagRepository->create($data);
    }

    public function find($id)
    {   

        return $this->blogTagRepository->find($id);
       
    }

    public function update(array $data, $id)
    {
        return $this->blogTagRepository->update($data,$id);
    }

    public function delete($id)
    {
        return $this->blogTagRepository->delete($id);
    }

}
