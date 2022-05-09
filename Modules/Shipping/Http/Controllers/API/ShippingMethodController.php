<?php

namespace Modules\Shipping\Http\Controllers\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Shipping\Services\ShippingService;


class ShippingMethodController extends Controller
{

    protected $shippingService;

    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    // Shipping List

    public function index(){
        $shippings = $this->shippingService->getActiveAll();
        if(count($shippings) > 0){
            return response()->json([
                'shippings' => $shippings,
                'msg' => 'success'
            ]);
        }else{
            return response()->json([
                'msg' => 'empty list'
            ]);
        }
    }
}
