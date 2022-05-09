<?php
namespace Modules\Marketing\Repositories;

use App\Models\Subscription;

class SubscriberRepository {

    public function getAll(){
        return Subscription::latest();
    }

    public function deleteById($id){
        return Subscription::findOrFail($id)->delete();
    }

    public function statusChange($data){
        return Subscription::findOrFail($data['id'])->update([
            'status' => $data['status']
        ]);
    }
}
