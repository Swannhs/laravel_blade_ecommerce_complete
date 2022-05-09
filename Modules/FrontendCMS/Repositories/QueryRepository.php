<?php
namespace Modules\FrontendCMS\Repositories;

use Modules\FrontendCMS\Entities\InQuery;

class QueryRepository {

    protected $query;

    public function __construct(InQuery $query){
        $this->query = $query;
    }


    public function getAll()
    {
        return $this->query::all();
    }
    public function getAllActive()
    {
        return $this->query::where('status',1)->get();
    }

    public function save($data)
    {   
        return $this->query::create([
            'name' => $data['name'],
            'status' => $data['status']
        ]);
        
    }

    public function update($data, $id)
    {   
        return $this->query::where('id',$id)->update([
            'name' => $data['name'],
            'status' => $data['status']
        ]);

    }

    public function delete($id){
        $query = $this->query->findOrFail($id);
        $query->delete();

        return $query;
    }

    public function show($id){
        $query = $this->query->findOrFail($id);
        return $query;
    }

    public function edit($id){
        $query = $this->query->findOrFail($id);
        return $query;
    }
    public function statusUpdate($data, $id){
        return $this->query::where('id',$id)->update([
            'status' => $data['status']
        ]);
    }
}
