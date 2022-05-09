<?php

namespace Modules\Setup\Http\Controllers\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setup\Services\CountryService;


class LocationController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    // Country

    public function getCountry(){
        $countries = $this->countryService->getActiveAll();

        if(count($countries) > 0){
            return response()->json([
                'countries' => $countries,
                'message' => 'success'
            ], 200);
        }else{
            return response()->json([
                'message' => 'not found'
            ]);
        }
    }

    // State by Country

    public function getStateByCountry($id){
        $states = $this->countryService->getStateByCountry($id);
        if(count($states) > 0){
            return response()->json([
                'states' => $states,
                'message' => 'success'
            ], 200);
        }else{
            return response()->json([
                'message' => 'not found'
            ]);
        }
    }


    // City by state

    public function getCityByState($id){
        $cities = $this->countryService->getCityByState($id);
        if(count($cities) > 0){
            return response()->json([
                'cities' => $cities,
                'message' => 'success'
            ], 200);
        }else{
            return response()->json([
                'message' => 'not found'
            ]);
        }
    }
}
