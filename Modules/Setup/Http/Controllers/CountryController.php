<?php

namespace Modules\Setup\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setup\Services\CountryService;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Modules\UserActivityLog\Traits\LogActivity;

class CountryController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->middleware('maintenance_mode');
        $this->countryService = $countryService;
    }
    
    public function index()
    {

        try{
            $countries = $this->countryService->getAll();

            return view('setup::location.country.index', compact('countries'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return $e->getMessage();
        }
    }

    public function store(Request $request){
        

        $request->validate([
            'name' =>'required|max:255|unique:countries',
            'code' => 'required|max:255|unique:countries',
            'phonecode' => 'required|max:255',
            'flag' => 'nullable|mimes:jpg,jpeg,bmp,png'
        ]);

        try{
            $this->countryService->store($request->except('_token'));
            LogActivity::successLog('Country Created Successfully');
            return $this->reloadWithData();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
        
    }

    public function edit($id){
        
        try{
            $country = $this->countryService->getById($id);
            return view('setup::location.country.components.edit',compact('country'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

    public function update(Request $request){
        
        $request->validate([
            'name' =>'required|max:255|unique:countries,name,'.$request->id,
            'code' => 'required|max:255|unique:countries,code,'.$request->id,
            'phonecode' => 'required|max:255',
            'flag' => 'nullable|mimes:jpg,jpeg,bmp,png'
        ]);

        try{
            $this->countryService->update($request->except('_token'));
            LogActivity::successLog('Country Updated Successfully');
            return $this->reloadWithData();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
         
    }

    public function status(Request $request){
        
        try{
            $this->countryService->status($request->except('_token'));
            LogActivity::successLog('country status updated successfully');
            return true;
            
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

    public function get_states(Request $request){
        return $this->countryService->getStateByCountry($request->get('country_id'));
    }
    public function get_cities(Request $request){
        return $this->countryService->getCityByState($request->get('state_id'));
    }

    private function reloadWithData(){

        try{
            $countries = $this->countryService->getAll();

            return response()->json([

                'TableData' =>  (string)view('setup::location.country.components.list', compact('countries')),
                'createForm' =>  (string)view('setup::location.country.components.create')
            ],200);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

}
