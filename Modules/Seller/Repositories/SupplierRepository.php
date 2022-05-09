<?php
namespace Modules\Seller\Repositories;

// use \Modules\FrontendCMS\Entities\AboutUs;
use Illuminate\Support\Facades\Auth;
use \Modules\Seller\Entities\Supplier;

class SupplierRepository {

    protected $supplier;

    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }    
    
    public function getAll(){
        return $this->supplier::where('user_id',auth()->user()->id)->get();
    }
    

    public function store($data){
        
        return $this->supplier::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone_number'],
            'alternate_phone' => $data['alternate_phone_number'],
            'business_name' => $data['business_name'],
            'url' => $data['url'],
            'address' => $data['address'],
            'tax_number' => $data['tax_number'],
            'opening_balance' => $data['opening_balance'],
            'payterm' => $data['payterm'],
            'payterm_condition' => $data['payterm_condition'],
            'country' => $data['country'],
            'state' => $data['state'],
            'city' => $data['city'],
            'postcode' => $data['postcode'],
            'status' => $data['status'],
            'description' => $data['description'],
            
            'photo' => $data['photo'],
            'user_id' => auth()->user()->id,
            'supplier_id' => 'sup-'.rand(9999,1000000)
        ]);
    }
    public function editByID($id){
        return $this->supplier::findOrFail($id);
    }
    
    public function update($data, $id){
        return $this->supplier::findOrFail($id)->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone_number'],
            'alternate_phone' => $data['alternate_phone_number'],
            'business_name' => $data['business_name'],
            'url' => $data['url'],
            'address' => $data['address'],
            'tax_number' => $data['tax_number'],
            'opening_balance' => $data['opening_balance'],
            'payterm' => $data['payterm'],
            'payterm_condition' => $data['payterm_condition'],
            'country' => $data['country'],
            'state' => $data['state'],
            'city' => $data['city'],
            'postcode' => $data['postcode'],
            'status' => $data['status'],
            'description' => $data['description'],
            
            'photo' => $data['photo'],
        ]);
    }

    public function deleteByID($id){

        return $this->supplier::findOrFail($id)->delete();
    }
    public function statusChange($data){
        return $this->supplier::findOrFail($data['id'])->update([
            'status' =>$data['status']
        ]);
    }
    
}
