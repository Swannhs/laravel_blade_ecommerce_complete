<?php

namespace Modules\Marketing\Http\Controllers\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Marketing\Services\FlashDealsService;
use Modules\Marketing\Transformers\FlashDealResource;


class FlashDealController extends Controller
{
    protected $flashDealsService;

    public function __construct(FlashDealsService $flashDealsService)
    {
        $this->flashDealsService = $flashDealsService;
    }
    
    // Flash Deal

    public function getActiveFlashDeal(){

        $flash_deal = new FlashDealResource($this->flashDealsService->getActiveFlashDeal());

        if($flash_deal){
            return response()->json([
                'flash_deal' => $flash_deal
            ],200);
        }else{
            return response()->json([
                'message' => 'not found'
            ],404);
        }
    }
}
