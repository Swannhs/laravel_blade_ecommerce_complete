<?php

namespace Modules\Seller\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Seller\Repositories\SupplierRepository;
use App\Traits\ImageStore;

class SupplierService{
    use ImageStore;

    protected $supplierRepository;

    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function getAll(){
        return $this->supplierRepository->getAll();
    }

    public function store($data){
        if(isset($data['photo'])){
            $imagename = ImageStore::saveImage($data['photo']);
            $newData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'alternate_phone_number' => $data['alternate_phone_number'],
                'business_name' => $data['business_name'],
                'url' => $data['url'],
                'address' => $data['address'],
                'tax_number' => $data['tax_number'],
                'opening_balance' => $data['opening_balance'],
                'payterm' => $data['payterm'],
                'payterm_condition' => isset($data['payterm_condition'])?$data['payterm_condition']:null,
                'country' => $data['country'],
                'state' => $data['state'],
                'city' => $data['city'],
                'postcode' => $data['postcode'],
                'status' => $data['status'],
                'description' => $data['description'],
                
                'photo' => $imagename
            ];
        }else{
            $newData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'alternate_phone_number' => $data['alternate_phone_number'],
                'business_name' => $data['business_name'],
                'url' => $data['url'],
                'address' => $data['address'],
                'tax_number' => $data['tax_number'],
                'opening_balance' => $data['opening_balance'],
                'payterm' => $data['payterm'],
                'payterm_condition' => isset($data['payterm_condition'])?$data['payterm_condition']:null,
                'country' => $data['country'],
                'state' => $data['state'],
                'city' => $data['city'],
                'postcode' => $data['postcode'],
                'status' => $data['status'],
                'description' => $data['description'],
                
                'photo' => null
            ];
        }
        return $this->supplierRepository->store($newData);
    }

    public function editByID($id){
        return $this->supplierRepository->editByID($id);
    }

    public function update ($data, $id){
        $supplier = $this->supplierRepository->editByID($id);

        if(isset($data['photo'])){
            ImageStore::deleteImage($supplier->photo);
            $imagename = ImageStore::saveImage($data['photo']);
            $newData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'alternate_phone_number' => $data['alternate_phone_number'],
                'business_name' => $data['business_name'],
                'url' => $data['url'],
                'address' => $data['address'],
                'tax_number' => $data['tax_number'],
                'opening_balance' => $data['opening_balance'],
                'payterm' => $data['payterm'],
                'payterm_condition' => isset($data['payterm_condition'])?$data['payterm_condition']:$supplier->payterm_condition,
                'country' => $data['country'],
                'state' => $data['state'],
                'city' => $data['city'],
                'postcode' => $data['postcode'],
                'status' => $data['status'],
                'description' => $data['description'],
                
                'photo' => $imagename
            ];
        }else{
            $newData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'alternate_phone_number' => $data['alternate_phone_number'],
                'business_name' => $data['business_name'],
                'url' => $data['url'],
                'address' => $data['address'],
                'tax_number' => $data['tax_number'],
                'opening_balance' => $data['opening_balance'],
                'payterm' => $data['payterm'],
                'payterm_condition' => isset($data['payterm_condition'])?$data['payterm_condition']:$supplier->payterm_condition,
                'country' => $data['country'],
                'state' => $data['state'],
                'city' => $data['city'],
                'postcode' => $data['postcode'],
                'status' => $data['status'],
                'description' => $data['description'],
                
                'photo' => $supplier->photo
            ];
        }

        return $this->supplierRepository->update($newData,$id);


    }
    public function deleteByID($id){
        $supplier = $this->supplierRepository->editByID($id);
        ImageStore::deleteImage($supplier->photo);
        return $this->supplierRepository->deleteByID($id);
    }

    public function statusChange($data){
        return $this->supplierRepository->statusChange($data);
    }


}
