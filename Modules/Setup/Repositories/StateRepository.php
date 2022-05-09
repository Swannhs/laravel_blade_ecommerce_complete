<?php

namespace Modules\Setup\Repositories;

use Modules\Setup\Entities\Country;
use Modules\Setup\Entities\State;

class StateRepository{

    public function getAll(){
        return State::with('country')->orderBy('name');
    }

    public function getCountries(){
        return Country::where('status', 1)->orderBy('name')->get();
    }

    public function getByCountryId($countryId)
    {
        return State::where('country_id', $countryId)->where('status', 1)->orderBy('name')->get();
    }

    public function store($data){

        return State::create([
            'name' => $data['name'],
            'country_id' => $data['country'],
            'status' => $data['status']
        ]);
    }

    public function getById($id){
        return State::findOrFail($id);
    }

    public function update($data){

        $state = State::findOrFail($data['id']);

        return $state->update([
            'name' => $data['name'],
            'country_id' => $data['country'],
            'status' => $data['status']
        ]);

    }

    public function status($data){
        return State::where('id',$data['id'])->update([
            'status' => $data['status']
        ]);
    }

}

