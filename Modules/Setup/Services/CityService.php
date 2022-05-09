<?php
namespace Modules\Setup\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Setup\Repositories\CityRepository;

class CityService
{
    protected $cityRepository;

    public function __construct(CityRepository  $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function getAll(){
        return $this->cityRepository->getAll();
    }

    public function getCountries(){
        return $this->cityRepository->getCountries();
    }

    public function getStates(){
        return $this->cityRepository->getStates();
    }

    public function store($data){
        return $this->cityRepository->store($data);
    }

    public function getById($id){
        return $this->cityRepository->getById($id);
    }

    public function update($data){
        return $this->cityRepository->update($data);
    }
    
    public function status($data){
        return $this->cityRepository->status($data);
    }

    public function getStateByCountry($id){
        return $this->cityRepository->getStateByCountry($id);
    }
    
}
