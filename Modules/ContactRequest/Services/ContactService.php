<?php
namespace Modules\ContactRequest\Services;

use \Modules\ContactRequest\Repositories\ContactRepository;


class ContactService{

    protected $contact;

    public function __construct(ContactRepository $contact){
        $this->contact = $contact;
    }

    public function getAll(){
        return $this->contact->getAll();
    }

    public function statusUpdate($data, $id){
        return $this->contact->statusUpdate($data, $id);
    }

    public function deleteById($id){
        return $this->contact->deleteById($id);
    }
    public function getById($id){
        return $this->contact->getById($id);
    }
}
