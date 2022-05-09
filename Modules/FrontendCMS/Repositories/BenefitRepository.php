<?php
namespace Modules\FrontendCMS\Repositories;

use Modules\FrontendCMS\Entities\Benifit;

class BenefitRepository {

    protected $benefit;

    public function __construct(Benifit $benefit)
    {
        $this->benefit = $benefit;
    }

    public function getAll()
    {
        return $this->benefit::all();
    }
    public function getAllActive()
    {
        return $this->benefit::where('status',1)->get();
    }

    public function save($data)
    {

        return $this->benefit::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'image' => $data['image']
        ]);

    }

    public function update($data, $id)
    {
        return $this->benefit::where('id',$id)->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'image' => $data['image']
        ]);

    }


    public function delete($id){
        $benefit = $this->benefit->findOrFail($id);
        $benefit->delete();

        return $benefit;
    }


    public function edit($id){
        $benefit = $this->benefit->findOrFail($id);
        return $benefit;
    }
}
