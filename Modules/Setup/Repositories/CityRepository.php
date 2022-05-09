<?php

namespace Modules\Setup\Repositories;

use Modules\Setup\Entities\City;
use Modules\Setup\Entities\Country;
use Modules\Setup\Entities\State;

class CityRepository{

    public function getAll(){
        return City::with('state','state.country')->orderBy('name');
    }

    public function getCountries(){
        return Country::where('status', 1)->orderBy('name')->get();
    }

    public function getStates(){
        return State::where('status', 1)->orderBy('name')->get();
    }


    public function getByStateId($state_id)
    {
        return City::where('state_id', $state_id)->where('status', 1)->orderBy('name')->get();
    }


    public function getStateByCountry($id){

        $country = Country::findOrFail($id);
        return $country->states;
    }

    public function store($data){

        return City::create([
            'name' => $data['name'],
            'state_id' => $data['state'],
            'status' => $data['status']
        ]);

    }

    public function getById($id){
        return City::findOrFail($id);
    }

    public function update($data){

        return City::where('id', $data['id'])->update([
            'name' => $data['name'],
            'state_id' => $data['state'],
            'status' => $data['status']
        ]);
    }

    public function status($data){
        return City::where('id',$data['id'])->update([
            'status' => $data['status']
        ]);
    }

}

