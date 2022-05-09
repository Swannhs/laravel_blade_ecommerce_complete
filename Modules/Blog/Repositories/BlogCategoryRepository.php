<?php

namespace Modules\Blog\Repositories;
use Modules\Blog\Entities\BlogCategory;

class BlogCategoryRepository
{
    public function getAll()
    {
        return BlogCategory::where('parent_id',0)->with(['parent','childs'])->get();
    }
    
    public function create(array $data)
    {
        return BlogCategory::create($data);
    }

    public function find($id)
    {
        return BlogCategory::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        return BlogCategory::findOrFail($id)->update($data);
    }

    public function delete($id)
    {  
        $file=BlogCategory::findOrFail($id);
        if(file_exists($file->image_url)){
            unlink(public_path($file->image_url));
         }
        return $file->delete();
    }
}

