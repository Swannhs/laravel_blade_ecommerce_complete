<?php
namespace Modules\OrderManage\Repositories;

use Modules\OrderManage\Entities\CancelReason;
use Carbon\Carbon;

class CancelReasonRepository
{
    public function getAll()
    {
        return CancelReason::all();
    }

    public function save($data)
    {
        CancelReason::create([
            'name' => $data['name'],
            'description' => $data['description']
        ]);
    }

    public function update($data, $id)
    {
        CancelReason::findOrFail($id)->update([
            'name' => $data['name'],
            'description' => $data['description']
        ]);
    }

    public function delete($id)
    {
        return CancelReason::findOrFail($id)->delete();
    }

    public function getById($id){
        return CancelReason::find($id);
    }
}
