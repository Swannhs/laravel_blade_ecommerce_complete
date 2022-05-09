<?php
namespace App\Services;

use App\Repositories\ContactRepository;


class ContactService{

    protected $contact;

    public function __construct(ContactRepository $contact){
        $this->contact = $contact;
    }

    public function store($data){
        return $this->contact->store($data);
    }
}