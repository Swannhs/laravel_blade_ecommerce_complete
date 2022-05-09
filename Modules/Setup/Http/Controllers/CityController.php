<?php

namespace Modules\Setup\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setup\Services\CityService;
use Yajra\DataTables\Facades\DataTables;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Modules\UserActivityLog\Traits\LogActivity;

class CityController extends Controller
{
    protected $cityService;

    public function __construct(CityService $cityService)
    {
        $this->middleware('maintenance_mode');
        $this->cityService = $cityService;
    }
    
    public function index()
    {
        try{
            $countries = $this->cityService->getCountries();
            $states  = $this->cityService->getStates();
            return view('setup::location.city.index',compact('countries','states'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

    public function getData(){
        try{
            $cities = $this->cityService->getAll();
            return DataTables::of($cities)
            ->addIndexColumn()
            ->addColumn('country', function($cities){
                return @$cities->state->country->name;
                
            })
            ->addColumn('state', function($cities){
                return @$cities->state->name;
                
            })
            ->addColumn('status', function($cities){
                return view('setup::location.city.components.status_td',compact('cities'));
            })
            ->addColumn('action',function($cities){
                return view('setup::location.city.components.action_td',compact('cities'));
            })
            ->rawColumns(['status','action'])
            ->toJson();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

    public function getState(Request $request){
        try{
            $states = $this->cityService->getStateByCountry($request->country_id);
            return view('setup::location.city.components.get_state_by_country',compact('states'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

    public function store(Request $request){

        $request->validate([
            'name' =>'required|max:255',
            'country' =>'required',
            'state' => 'required'
        ]);
        
        try{
            $this->cityService->store($request->except('_token'));
            LogActivity::successLog('city created successfully');
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
            $city = $this->cityService->getById($id);
            $countries = $this->cityService->getCountries();
            return view('setup::location.city.components.edit',compact('city','countries'));
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
            'name' =>'required|max:255',
            'country' => 'required',
            'state' => 'required'
        ]);

        try{
            $this->cityService->update($request->except('_token'));
            LogActivity::successLog('city updated successfully');
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
            $this->cityService->status($request->except('_token'));
            LogActivity::successLog('city status change successfully');
            return true;
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

    private function reloadWithData(){

        try{
            $countries = $this->cityService->getCountries();

            return response()->json([
                'TableData' =>  (string)view('setup::location.city.components.list'),
                'createForm' =>  (string)view('setup::location.city.components.create',compact('countries'))
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
