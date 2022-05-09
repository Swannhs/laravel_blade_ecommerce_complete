<?php
namespace Modules\FrontendCMS\Repositories;

use Modules\FrontendCMS\Entities\Faq;

class FaqRepository {

    protected $faq;

    public function __construct(Faq $faq){
        $this->faq = $faq;
    }


    public function getAll()
    {
        return $this->faq->all();
    }
    public function getAllActive()
    {
        return $this->faq::where('status',1)->get();
    }

    public function save($data)
    {
        
        return $this->faq::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status']
        ]);
        
    }

    public function update($data, $id)
    {   
        return $this->faq::where('id',$id)->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status']
        ]);

    }

    public function delete($id){
        $faq = $this->faq->findOrFail($id);
        $faq->delete();

        return $faq;
    }

    public function show($id){
        $faq = $this->faq->findOrFail($id);
        return $faq;
    }

    public function edit($id){
        $faq = $this->faq->findOrFail($id);
        return $faq;
    }
}
