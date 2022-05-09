<?php

namespace Modules\Appearance\Http\Controllers\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Appearance\Services\HeaderService;
use Modules\Appearance\Transformers\SliderResource;


class HeaderController extends Controller
{
    protected $headerService;
    public function __construct(HeaderService $headerService)
    {
        $this->headerService = $headerService;
    }

    // Slider List

    public function getSliders(){
        $sliders = $this->headerService->getSliders();

        if(count($sliders) > 0){
            return SliderResource::collection($sliders);
        }else{
            return response()->json([
                'message' => 'slider not found'
            ],404);
        }
    }

    // Single slider

    public function getSingleSlider($id){
        $slider = $this->headerService->getSingleSlider($id);
        if($slider){
            return new SliderResource($slider);
        }else{
            return response()->json([
                'message' => 'slider not found'
            ],404);
        }
    }
}
