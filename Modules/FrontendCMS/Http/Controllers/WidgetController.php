<?php

namespace Modules\FrontendCMS\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FrontendCMS\Entities\HomePageSection;
use Modules\FrontendCMS\Services\WidgetService;
use Modules\Seller\Entities\SellerProduct;
use Exception;
use Modules\UserActivityLog\Traits\LogActivity;

class WidgetController extends Controller
{
    protected $widgetService;
    public function __construct(WidgetService $widgetService)
    {
        $this->middleware('maintenance_mode');
        $this->widgetService = $widgetService;
    }

    public function index()
    {
        try{
            $widgets = $this->widgetService->getAll();
            return view('frontendcms::widget_manage.index',compact('widgets'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function getsectionForm(Request $request){

        try{
            $data = $this->widgetService->getBySectionName($request->except('_token'));
            $products = $this->widgetService->getProducts();
            $categories = $this->widgetService->getCategories();
            $brands = $this->widgetService->getBrands();

            return response()->json([
                'form' =>  (string)view('frontendcms::widget_manage.components.formdata_best_deals',compact('data','products','categories','brands'))
            ]);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function update(Request $request){

        $request->validate([
            'title' => 'required',
            'type' => 'required',
            'column_size' => 'required',
            'status' =>'required'
        ]);
        try{
            $update = $this->widgetService->update($request->except('_token'));
            LogActivity::successLog('widget update successful.');
            return $update;
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }

    }


}
