<?php
namespace Modules\FrontendCMS\Repositories;

use \Modules\FrontendCMS\Entities\Feature;

class FeatureRepository {

    protected $feature;

    public function __construct(Feature $feature)
    {
        $this->feature = $feature;
    }


    public function getAll()
    {
        return $this->feature->get();
    }
    public function getActiveAll(){
        
        return $this->feature::where('status',1)->get();
    }

    public function save($data)
    {
        return $this->feature::create([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'icon' => $data['icon'],
            'status' => $data['status']
        ]);
    }

    public function update($data, $id)
    {
        $feature = $this->feature::where('id',$id)->first();
        $feature->update([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'icon' => $data['icon'],
            'status' => $data['status']
        ]);

        return $feature->fresh();
    }

    public function delete($id)
    {
        $feature = $this->feature->findOrFail($id);
        $feature->delete();

        return $feature;
    }

    public function show($id)
    {
        $feature = $this->feature->findOrFail($id);
        return $feature;
    }

    public function edit($id){
        $feature = $this->feature->findOrFail($id);
        return $feature;
    }
}
