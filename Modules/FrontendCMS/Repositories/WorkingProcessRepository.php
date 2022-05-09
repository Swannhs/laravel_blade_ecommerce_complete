<?php
namespace Modules\FrontendCMS\Repositories;

use Modules\FrontendCMS\Entities\WorkingProcess;

class WorkingProcessRepository {
    protected $workingProcess;

    public function __construct(WorkingProcess $workingProcess){
        $this->workingProcess = $workingProcess;
    }

    public function getAll()
    {
        return $this->workingProcess::all();
    }
    public function getAllActive(){
        return $this->workingProcess::where('status',1)->get();
    }

    public function save($data)
    {
        
        return $this->workingProcess::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'position' => $data['position'],
            'image' => $data['image']
        ]);
        
    }

    public function update($data, $id)
    {   
        return $this->workingProcess::where('id',$id)->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'position' => $data['position'],
            'image' => $data['image']
        ]);

    }
    

    public function delete($id){
        $workingProcess = $this->workingProcess->findOrFail($id);
        $workingProcess->delete();

        return $workingProcess;
    }


    public function edit($id){
        $workingProcess = $this->workingProcess->findOrFail($id);
        return $workingProcess;
    }
}