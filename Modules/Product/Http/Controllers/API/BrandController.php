<?php

namespace Modules\Product\Http\Controllers\API;

use App\Repositories\FilterRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Repositories\AttributeRepository;
use Modules\Product\Services\BrandService;
use Modules\Product\Transformers\BrandResource;


class BrandController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }
    
    // Brand List
    public function index()
    {
        $brands = $this->brandService->getActiveAll();
        
        if(count($brands) > 0){
            return BrandResource::collection($brands,200);
        }else{
            return response()->json([
                'message' => 'brnad not found'
            ],404);
        }
    }

    // Single Brand
    
    public function show($id)
    {
        $brand = $this->brandService->findById($id);
        $attributeRepo = new AttributeRepository;
        $attributes = $attributeRepo->getAttributeForSpecificBrand($id);
        $color = $attributeRepo->getColorAttributeForSpecificBrand($id);
        $filterRepo = new FilterRepository();
        $categories = $filterRepo->filterCategoryBrandWise($id);
        $products = $brand->sellerProductsAll()->pluck('id');
        $lowest_price = $filterRepo->filterProductMinPrice($products);
        $height_price = $filterRepo->filterProductMaxPrice($products);
        if($brand){
            $brand = new BrandResource($brand);
            return response()->json([
                'data' => $brand,
                'attributes' => $attributes,
                'color' => $color,
                'categories' => $categories,
                'lowest_price' => $lowest_price,
                'height_price' => $height_price
            ]);
        }else{
            return response()->json([
                'message' => 'brnad not found'
            ],404);
        }
    }


    
}
