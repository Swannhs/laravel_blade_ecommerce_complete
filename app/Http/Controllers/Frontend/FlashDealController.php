<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\FlashDealService;
use App\Traits\GoogleAnalytics4;
use Illuminate\Http\Request;

class FlashDealController extends Controller
{
    use GoogleAnalytics4;
    protected $flashDealService;
    public function __construct(FlashDealService $flashDealService)
    {
        $this->flashDealService = $flashDealService;
        $this->middleware('maintenance_mode');
    }

    public function show($slug){

        $Flash_Deal = $this->flashDealService->getById($slug);

        $products =  $Flash_Deal->products()->whereHas('product', function($query){
            $query->where('status', 1)->whereHas('product', function($query){
                $query->where('status', 1);
            });
        })->paginate(12);

        //ga4
        if(app('business_settings')->where('type', 'google_analytics')->first()->status == 1){
            $eData = [
                'name' => 'view_promotion',
                'params' => [

                    "items" => [
                        [
                            "item_id"=> 1,
                            "item_name"=> 'product',
                        ]
                    ],
                ],
            ];

            $this->postEvent($eData);
        }
        //end ga4

        if($Flash_Deal->status == 0){
            if(auth()->check() && auth()->user()->role->type == 'superadmin' || auth()->check() && auth()->user()->role->type == 'admin' || auth()->check() && auth()->user()->role->type == 'staff'){
                return view(theme('pages.flash_deal'), compact('Flash_Deal','products'));
            }else{
                return abort(404);
            }
        }else{
            return view(theme('pages.flash_deal'), compact('Flash_Deal','products'));
        }

    }

    public function fetchData(Request $request, $slug){

        $Flash_Deal = $this->flashDealService->getById($slug);
        $products =  $Flash_Deal->products()->whereHas('product', function($query){
            $query->where('status', 1)->whereHas('product', function($query){
                $query->where('status', 1);
            });
        })->paginate(12);
        return view(theme('partials.flash_deal_paginate_data'), compact('Flash_Deal','products'));

    }

}
