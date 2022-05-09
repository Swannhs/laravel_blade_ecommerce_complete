<?php

namespace Modules\Marketing\Http\Controllers\API;

use App\Repositories\NewUserZoneRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Marketing\Services\NewUserZoneService;


class NewUserZoneController extends Controller
{
    protected $newUserZoneService;

    public function __construct(NewUserZoneService $newUserZoneService)
    {
        $this->newUserZoneService = $newUserZoneService;
    }

    // New User Zone

    public function getActiveNewUserZone()
    {
        $data = $this->newUserZoneService->getActiveNewUserZone();

        if($data){
            return response()->json([
                'new_user_zone' => $data['new_user_zone'],
                'allCategoryProducts' => $data['allCategoryProducts'],
                'allCouponCategoryProducts' => $data['allCouponCategoryProducts'],
                'message' => 'success'
            ], 200);
        }else{
            return response()->json([
                'message' => 'not found'
            ], 400);
        }

    }

    
    // pagination from product


    public function fetchProductData($slug){
        $newuserRepo = new NewUserZoneRepository();
        $new_user_zone = $newuserRepo->getById($slug);
        $products = $new_user_zone->products()->paginate(12);
        $products->appends([
            'item' => 'product'
        ]);
        return response()->json($products);

    }

    // Pagination from single category

    public function fetchCategoryData(Request $request, $slug){
        $newuserRepo = new NewUserZoneRepository();
        $category = $newuserRepo->getCategoryById($request->parent_data);
        $products = $category->category->AllProducts;
        return response()->json($products);
    }

    // Pagination from single coupon category

    public function fetchCouponCategoryData(Request $request, $slug){
        $newuserRepo = new NewUserZoneRepository();
        $category = $newuserRepo->getCouponCategoryById($request->parent_data);
        $products = $category->category->AllProducts;
        return response()->json($products);
    }

    // Pagination from all category

    public function fetchAllCategoryData($slug){
        $newuserRepo = new NewUserZoneRepository();
        $allCategoryProducts = $newuserRepo->getAllProductsForCategories($slug);
        return response()->json([
            'allCategoryProducts' => $allCategoryProducts
        ]);
    }

    // Pagination from all coupon category

    public function fetchAllCouponCategoryData($slug){
        $newuserRepo = new NewUserZoneRepository();
        $allCouponCategoryProducts = $newuserRepo->getAllProductsForCouponCategories($slug);
        return response()->json([
            'allCouponCategoryProducts' => $allCouponCategoryProducts
        ]);
    }

    
}
