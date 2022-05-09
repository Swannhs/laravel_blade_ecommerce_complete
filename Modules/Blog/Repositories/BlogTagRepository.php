<?php

namespace Modules\Blog\Repositories;
use Modules\Blog\Entities\BlogTag;

class BlogTagRepository
{
    public function getAll()
    {
        return BlogTag::all();
    }

    public function create(array $data)
    {
        return BlogTag::create($data);
    }

    public function find($id)
    {
        return BlogTag::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        return BlogTag::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return BlogTag::findOrFail($id)->delete();
    }
}

