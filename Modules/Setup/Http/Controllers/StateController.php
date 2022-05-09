<?php

namespace Modules\Setup\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setup\Services\StateService;
use Yajra\DataTables\Facades\DataTables;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Modules\UserActivityLog\Traits\LogActivity;

class StateController extends Controller
{
    protected $stateService;

    public function __construct(StateService $stateService)
    {
        $this->middleware('maintenance_mode');
        $this->stateService = $stateService;
    }
    
    public function index()
    {
        try{
            $countries = $this->stateService->getCountries();
            return view('setup::location.state.index',compact('countries'));
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
            $states = $this->stateService->getAll();
            return DataTables::of($states)
            ->addIndexColumn()
            ->addColumn('country', function($states){
                return @$states->country->name;
            })
            ->addColumn('status', function($states){
                return view('setup::location.state.components.status_td',compact('states'));
            })
            ->addColumn('action',function($states){
                return view('setup::location.state.components.action_td',compact('states'));
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

    public function store(Request $request){
        $request->validate([
            'name' =>'required|max:255',
            'country' =>'required'
        ]);
        
        try{
            $this->stateService->store($request->except('_token'));
            LogActivity::successLog('State created successfully');
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
            $state = $this->stateService->getById($id);
            $countries = $this->stateService->getCountries();
            return view('setup::location.state.components.edit',compact('state','countries'));
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
            'country' => 'required'
        ]);

        try{
            $this->stateService->update($request->except('_token'));
            LogActivity::successLog('State updated successfully');
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
            $this->stateService->status($request->except('_token'));
            LogActivity::successLog('State status change successfully');
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
            $countries = $this->stateService->getCountries();

            return response()->json([
                'TableData' =>  (string)view('setup::location.state.components.list'),
                'createForm' =>  (string)view('setup::location.state.components.create',compact('countries'))
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
