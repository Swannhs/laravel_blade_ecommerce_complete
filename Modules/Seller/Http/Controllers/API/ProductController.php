<?php

namespace Modules\Seller\Http\Controllers\API;

use App\Services\FilterService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\Seller\Services\ProductService;
use Modules\Seller\Transformers\ProductResource;


class ProductController extends Controller
{
    protected $productService;
    protected $filterService;

    public function __construct(ProductService $productService, FilterService $filterService)
    {
        $this->productService = $productService;
        $this->filterService = $filterService;
    }

    // Seller Products
    
    public function index()
    {
        $products = $this->productService->getAllSellerProduct();
        return ProductResource::collection($products);
    }


    // Show single product

    public function show($id){
        $product = $this->productService->getSellerProductById($id);
        if($product){
            return new ProductResource($product);
        }else{
            return response([
                'message' => 'not found'
            ],404);
        }
    }

    // sku wise price

    public function getSKUWisePrice(Request $request){

        return $this->productService->get_seller_product_sku_wise_price($request->except('_token'));
    }

    // Recomanded product
    public function recomandedProduct(){
        $products = $this->productService->getRecomandedProduct();
        if(count($products) > 0){
            return ProductResource::collection($products);
        }else{
            return response()->json([
                'message' => 'product not found'
            ], 404);
        }
    }

    // Top Picks
    public function topPicks(){
        $products = $this->productService->getTopPicks();
        return ProductResource::collection($products);
    }

    // Sort Before Filter

    public function sortProductBeforeFilter(Request $request){
        $request->validate([
            'requestItem' => 'required',
            'requestItemType' => 'required'
        ]);
        $paginate_by = null;
        $sort_by = null;
        if($request->has('sort_by')){
            $sort_by = $request->sort_by;
        }
        if($request->has('paginate_by')){
            $paginate_by = $request->paginate_by;
        }


        $products = $this->filterService->productSortByCategory($request->requestItemType,$request->requestItem, $sort_by, $paginate_by);

        return ProductResource::collection($products);
        
    }


    // Filter Product from single Category, brand, etc

    public function filterProductByType(Request $request){
        
        $paginate_by = null;
        $sort_by = null;
        if($request->has('sort_by')){
            $sort_by = $request->sort_by;
        }
        if($request->has('paginate_by')){
            $paginate_by = $request->paginate_by;
        }


        $products = $this->filterService->filterProductBlade($request->except("_token"), $sort_by, $paginate_by);

        return ProductResource::collection($products);
    }

    


    // sort after filter product

    public function filterSortProductByType (Request $request){
        if ($request->has('filterDataFromCat')) {
            $products = $this->filterService->filterSortProductBlade($request->except("_token"),$request->filterDataFromCat);
        }
        else {
            $products = $this->filterService->productSortByCategory($request->requestItemType,$request->requestItem, $request->sort_by, $request->paginate);
        }

        return ProductResource::collection($products);
        
    }

    // Filter product By Type than paginate
    public function fetchFilterPagenateDataByType(Request $request){
        
        $sort_by = null;
        $paginate = null;
        if ($request->has('sort_by')) {
            $sort_by = $request->sort_by;
        }
        if ($request->has('paginate')) {
            $paginate = $request->paginate;
        }
        $products = $this->filterService->filterProductAPI($request->filterDataFromCat, $sort_by, $paginate);

        return ProductResource::collection($products);
    }

    // Filter Product From Main Category Page


    public function filterProductByTypeGlobal(Request $request){
        $products = $this->filterService->filterProductFromCategoryBlade($request->except("_token"), null, null);
        return ProductResource::collection($products);
    }

    // Fetch Product From Main Category Page

    public function fetchDataGlobal(Request $request){
        $sort_by = null;
        $paginate = null;
        if ($request->has('sort_by')) {
            $sort_by = $request->sort_by;
        }
        if ($request->has('paginate')) {
            $paginate = $request->paginate;
        }
        $products = $this->filterService->getAllActiveProduct($sort_by, $paginate);

        return ProductResource::collection($products);
    }


    
}
