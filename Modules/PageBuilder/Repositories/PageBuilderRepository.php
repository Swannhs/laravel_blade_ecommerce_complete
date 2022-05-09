<?php


namespace Modules\PageBuilder\Repositories;


use Illuminate\Support\Str;
use Modules\FrontendCMS\Entities\DynamicPage;

class PageBuilderRepository
{
    public function all()
    {
        return DynamicPage::where('is_page_builder',1)->get();
    }

    public function create(array $data)
    {
         return DynamicPage::create([
             'title' =>$data['title'],
             'slug'  =>Str::slug($data['slug'], '-'),
             'status' => 1,
             'is_static' => 0,
             'is_page_builder' =>1
         ]);
    }

    public function find($id)
    {
        return DynamicPage::findOrFail($id);
    }

    public function designUpdate(array $data,$id)
    {
        return DynamicPage::where('id',$id)->update([
            'description'  => $data['body'],
        ]);
    }

    public function update(array $data,$id)
    {
        return DynamicPage::create([
            'title' =>$data['title'],
            'slug'  =>Str::slug($data['slug'], '-'),
        ]);
    }

    public function delete($id){
        return DynamicPage::findOrFail($id)->delete();
    }
    public function status($data){
        return DynamicPage::findOrFail($data['id'])->update(['status' => $data['status']]);
    }

}
