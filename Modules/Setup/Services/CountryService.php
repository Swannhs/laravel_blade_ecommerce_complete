<?php
namespace Modules\Setup\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Setup\Repositories\CountryRepository;

class CountryService
{
    protected $countryRepository;

    public function __construct(CountryRepository  $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function getAll(){
        return $this->countryRepository->getAll();
    }

    public function getActiveAll(){
        return $this->countryRepository->getActiveAll();
    }

    public function store($data){
        return $this->countryRepository->store($data);
    }

    public function getById($id){
        return $this->countryRepository->getById($id);
    }

    public function update($data){
        return $this->countryRepository->update($data);
    }

    public function status($data){
        return $this->countryRepository->status($data);
    }

    public function getStateByCountry($id){
        return $this->countryRepository->getStateByCountry($id);
    }

    public function getCityByState($id){
        return $this->countryRepository->getCityByState($id);
    }
    
}
