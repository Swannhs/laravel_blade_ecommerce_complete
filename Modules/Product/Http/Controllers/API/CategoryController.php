<?php

namespace Modules\Product\Http\Controllers\API;

use App\Repositories\FilterRepository;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Repositories\AttributeRepository;
use \Modules\Product\Services\CategoryService;
use Modules\Product\Transformers\CategoryResource;
use Modules\Seller\Entities\SellerProduct;


class CategoryController extends Controller
{

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    // Category List

    public function index(){

        $categories = $this->categoryService->getActiveAll();
        if(count($categories) > 0){
            return CategoryResource::collection($categories);
        }else{
            return response()->json([
                'message' => 'category not found'
            ],404);
        }
        
    }

    // Single Category

    public function show($id){

        $category = $this->categoryService->showById($id);
        $category_ids = $this->categoryService->getAllSubSubCategoryID($id);

        $attributeRepo = new AttributeRepository;
        $attributes = $attributeRepo->getAttributeForSpecificCategory($id, $category_ids);
        $color = $attributeRepo->getColorAttributeForSpecificCategory($id, $category_ids);
        $filterRepo = new FilterRepository();
        $brands = $filterRepo->filterBrandCategoryWise($id, $category_ids);
        $category_ids = array_merge($category_ids,[intval($id)]);
        $catProducts = SellerProduct::where('status', 1)->whereHas('product', function($query) use ($id, $category_ids){
            return $query->Wherehas('categories',function($q)use($category_ids){
                return $q->whereIn('category_id', $category_ids);
            });
        })->pluck('id');
        $lowest_price = $filterRepo->filterProductMinPrice($catProducts);
        $height_price = $filterRepo->filterProductMaxPrice($catProducts);
        if($category){
            $category = new CategoryResource($category);
            return response()->json([
                'data' => $category,
                'attributes' => $attributes,
                'color' => $color,
                'brands' => $brands,
                'lowest_price' => $lowest_price,
                'height_price' => $height_price

            ],200);
        }else{
            return response()->json([
                'message' => 'category not found'
            ],404);
        }
    }

    // Top Categories

    public function topCategory(){
        $categories =  $this->categoryService->getCategoryByTop();
        
        if(count($categories) > 0){
            return CategoryResource::collection($categories,200);
        }else{
            return response()->json([
                'message' => 'category not found'
            ],404);
        }
    }

}
