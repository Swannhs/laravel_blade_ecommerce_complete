<?php
namespace Modules\ContactRequest\Repositories;

use App\Models\Contact;

class ContactRepository{

    protected $contact;

    public function __construct(Contact $contact){
        $this->contact = $contact;
    }

    public function getAll(){
        return $this->contact::all();
    }

    public function getById($id){
        return $this->contact::findOrFail($id);
    }



    public function statusUpdate($data, $id){
        return $this->contact::where('id',$id)->update([
            'status' => $data['status']
        ]);
    }

    public function deleteById($id){

        return $this->contact->findOrFail($id)->delete();
    }
}
