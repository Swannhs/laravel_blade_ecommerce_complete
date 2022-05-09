<?php
namespace Modules\Refund\Repositories;

use Modules\Refund\Entities\RefundReason;
use Carbon\Carbon;

class RefundReasonRepository
{
    public function getAll()
    {
        return RefundReason::latest()->get();
    }

    public function save($data)
    {
        RefundReason::create([
            'reason' => $data['reason']
        ]);
    }

    public function update($data, $id)
    {
        RefundReason::findOrFail($id)->update([
            'reason' => $data['reason']
        ]);
    }

    public function delete($id)
    {
        return RefundReason::findOrFail($id)->delete();
    }

    public function getById($id){
        return RefundReason::find($id);
    }
}
