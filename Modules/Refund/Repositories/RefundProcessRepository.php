<?php
namespace Modules\Refund\Repositories;

use Modules\Refund\Entities\RefundProcess;
use Carbon\Carbon;

class RefundProcessRepository
{
    public function getAll()
    {
        return RefundProcess::all();
    }

    public function save($data)
    {
        RefundProcess::create([
            'name' => $data['name'],
            'description' => $data['description']
        ]);
    }

    public function update($data, $id)
    {
        RefundProcess::findOrFail($id)->update([
            'name' => $data['name'],
            'description' => $data['description']
        ]);
    }

    public function delete($id)
    {
        return RefundProcess::findOrFail($id)->delete();
    }

    public function getById($id){
        return RefundProcess::find($id);
    }
}
