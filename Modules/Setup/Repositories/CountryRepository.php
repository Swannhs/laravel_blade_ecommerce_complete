<?php

namespace Modules\Setup\Repositories;

use Modules\Setup\Entities\Country;
use App\Traits\ImageStore;
use Modules\Setup\Entities\City;
use Modules\Setup\Entities\State;

class CountryRepository{
    use ImageStore;

    public function getAll(){
        return Country::orderBy('name')->get();
    }

    public function getActiveAll(){
        return Country::orderBy('name')->where('status', 1)->get();
    }
    
    public function store($data){

        if(isset($data['flag'])){
            $imagename = ImageStore::saveFlag($data['flag'],$data['name'],61,36);
            $data['flag'] = $imagename;
        }
        Country::create([
            'name' => $data['name'],
            'code' => $data['code'],
            'phonecode' => $data['phonecode'],
            'flag' => isset($data['flag'])?$data['flag']:null,
            'status' => $data['status']
        ]);
        return true;
    }

    public function getById($id){
        return Country::findOrFail($id);
    }

    public function update($data){

        $country = Country::findOrFail($data['id']);
        if(isset($data['flag'])){
            ImageStore::deleteImage($country->flag);

            $imagename = ImageStore::saveFlag($data['flag'],$data['name'],61,36);
            $data['flag'] = $imagename;
        }else{
            $data['flag'] = $country->flag;
        }

        $country->update([
            'name' => $data['name'],
            'code' => $data['code'],
            'phonecode' => $data['phonecode'],
            'flag' => $data['flag'],
            'status' => $data['status']
        ]);

        return true;
    }

    public function status($data){
        return Country::where('id',$data['id'])->update([
            'status' => $data['status']
        ]);
    }    

    public function getStateByCountry($id){
        return State::with('country')->where('status', 1)->where('country_id', $id)->orderBy('name')->get();
    }

    public function getCityByState($id){
        return City::with('state')->where('status', 1)->where('state_id', $id)->orderBy('name')->get();
    }
}
    
