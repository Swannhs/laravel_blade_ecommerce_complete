<?php
namespace Modules\FooterSetting\Repositories;

use \Modules\FooterSetting\Entities\FooterWidget;
use \Modules\FrontendCMS\Entities\DynamicPage;

class FooterWidgetRepository {

    protected $widget;
    protected $dynamicPage;

    public function __construct(FooterWidget $widget, DynamicPage $dynamicPage)
    {
        $this->widget = $widget;
        $this->dynamicPage = $dynamicPage;
    }

    public function getAll(){
        return $this->dynamicPage::where('is_static',1)->get();
    }
    public function getAllCompany(){
        return $this->widget::where('section','1')->orderBy('id','ASC')->get();
    }
    public function getAllAccount(){
        return $this->widget::where('section','2')->orderBy('id','ASC')->get();
    }
    public function getAllService(){
        return $this->widget::where('section','3')->orderBy('id','ASC')->get();
    }
    

    public function save($data){
        $page = DynamicPage::findOrFail($data['page']);
        return $this->widget::create([
            'name' => $data['name'],
            'slug' => $page->slug,
            'category' => $data['section_id'],
            'section' => $data['section_id'],
            'page' => $data['page'],
            'status' => 1,
            'is_static' => 0,
            'user_id' => auth()->user()->id
        ]);
    }

    public function update($data, $id)
    {
        $page = DynamicPage::findOrFail($data['page']);

        return $this->widget::where('id',$id)->first()->update([
            'name' => $data['name'],
            'slug' => $page->slug,
            'page' => $data['page']
        ]);
        
    }

    public function edit($id){
        $widget = $this->widget->findOrFail($id);
        return $widget;
    }

    public function statusUpdate($data, $id){
        return $this->widget::where('id',$id)->first()->update([
            'status' => $data['status']
        ]);
    }

    public function delete($id){
        return $this->widget->findOrFail($id)->delete();
    }
}
