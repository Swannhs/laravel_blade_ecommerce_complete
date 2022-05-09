<?php

namespace Modules\Setup\Repositories;

use Modules\Setup\Entities\Tag;
use Auth;

class TagRepository
{
    public function getAll()
    {
        return Tag::all();
    }

    public function create(array $data)
    {
        return Tag::create($data);
    }

    public function find($id)
    {
        return Tag::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        return Tag::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return Tag::findOrFail($id)->delete();
    }

    public function getTagBySentence($sentence)
    {
        $keywords = explode(' ', $sentence);
        $tags = Tag::whereIn('name', $keywords)->inRandomOrder()->take(6)->get();
        $result = "";
        foreach ($tags as $tag) {
            $result .=  '<a href="#" class="tag-add">'.$tag->name.'</a>&nbsp&nbsp&nbsp&nbsp';
        }
        return $result;
    }
    public function is_tag($name)
    {
        return Tag::where('name',$name)->first();
    }
}
