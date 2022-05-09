<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CompareService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Modules\UserActivityLog\Traits\LogActivity;

class CompareController extends Controller
{

    protected $compareService;

    public function __construct(CompareService $compareService)
    {
        $this->compareService = $compareService;
        $this->middleware('maintenance_mode');
    }

    public function index(){

        if(auth()->check()){
            $products = $this->compareService->getProduct(auth()->user()->id);
        }else{
            $products = $this->compareService->getProduct(null);
        }
        return view(theme('pages.compare'),compact('products'));
    }

    public function store(Request $request){

        if(auth()->check()){
            $compare = $this->compareService->store($request->except('_token'), auth()->user()->id);
        }else{
            $compare = $this->compareService->store($request->except('_token'), null);
        }
        LogActivity::successLog('compare store successful.');
        $totalItems = $this->countCompare();
        return response()->json([
            'msg' => 'done',
            'totalItems' => $totalItems
        ]);
    }

    private function countCompare(){
        $totalItems = 0;
        if(auth()->check()){
            $totalItems = $this->compareService->totalCompareItem(auth()->user()->id);
        }else{
            $totalItems = $this->compareService->totalCompareItem(null);
        }
        return $totalItems;
    }

    public function removeItem(Request $request){


        if(auth()->check()){
            $this->compareService->removeItem($request->product_sku_id, auth()->user()->id);
            $products = $this->compareService->getProduct(auth()->user()->id);
        }else{
            $this->compareService->removeItem($request->product_sku_id, null);
            $products = $this->compareService->getProduct(null);
        }

        LogActivity::successLog('item remove successful.');
        $totalItems = $this->countCompare();
        return response()->json([
            'page' => (string)view(theme('partials._compare_list'), compact('products')),
            'totalItems' => $totalItems
        ]);

    }

    public function reset(Request $request){

        if(auth()->check()){
            $this->compareService->reset(auth()->user()->id);
            $products = $this->compareService->getProduct(auth()->user()->id);
        }else{
            $this->compareService->reset(null);
            $products = $this->compareService->getProduct(null);
        }
        LogActivity::successLog('compare reset successful.');
        
        $totalItems = $this->countCompare();
        return response()->json([
            'page' => (string)view(theme('partials._compare_list'), compact('products')),
            'totalItems' => $totalItems
        ]);
    }


}
