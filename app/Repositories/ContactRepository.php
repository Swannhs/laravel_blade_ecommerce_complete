<?php
namespace App\Repositories;

use App\Models\Contact;
use App\Traits\ImageStore;


class ContactRepository{

    use ImageStore;

    protected $contact;

    public function __construct(Contact $contact){
        $this->contact = $contact;
    }

    public function store($data){

        $c_data = [];
        if($data->has('custom_field')){
            foreach (json_decode($data['custom_field']) as  $key => $f){
                if($data->hasFile($f)){
                    $file = ImageStore::saveImage($data[$f], 165, 165);
                    $c_data[$f] = $file;
                }else{
                    $c_data[$f] = $data[$f];
                }
            }
        }

        return $this->contact::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'query_type' => $data['query_type'],
            'message' => $data['message'],
            'others' => $this->othersFieldValue($c_data),
        ]);
    }

    protected function othersFieldValue($data)
    {
        return json_encode($data);
    }
}
