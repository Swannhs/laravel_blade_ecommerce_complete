<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SellerResource;
use App\Repositories\SellerRepository;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    protected $sellerRepository;
    public function __construct(SellerRepository $sellerRepository){
        $this->sellerRepository = $sellerRepository;
    }


    // Seller List

    public function sellerList(){
        $sellers = $this->sellerRepository->GetSellerList();
        if(count($sellers) > 0){
            return response()->json([
                'sellers' => $sellers,
                'mesage' => 'success'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Empty list'
            ], 404);
        }
    }


    // Single Seller
    public function getSellerById($id){
        $seller = $this->sellerRepository->getSellerByIDAPI($id);
        $categoryList = $this->sellerRepository->getCategoryList($id);
        $brandList = $this->sellerRepository->getBrandList($id);
        $lowestPrice = $this->sellerRepository->getProductLowestPrice($id);
        $heightPrice = $this->sellerRepository->getProductHighestPrice($id);
        if($seller == 'seller not found'){
            return response()->json([
                'message' => 'Seller not found'
            ],404);
        }
        elseif($seller){
            return response()->json([
                'seller' => new SellerResource($seller),
                'categoryList' => $categoryList,
                'brandList' => $brandList,
                'lowestPrice' => $lowestPrice,
                'heightPrice' => $heightPrice,
                'message' => 'success'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Not found'
            ], 404);
        }
    }

    // Filter From Seller

    public function filterByType(Request $request){

        $request->validate([
            'seller_id' => 'required'
        ]);

        $sort_by = 'old';
        $paginate = 1;
        if ($request->has('sort_by')) {
            $sort_by = $request->sort_by;
        }
        if ($request->has('paginate')) {
            $paginate = $request->paginate;
        }
        $products = $this->sellerRepository->filterProductBlade($request->except("_token"), $sort_by, $paginate, $request->seller_id);

        return response()->json([
            'products' => $products,
            'message' => 'success'
        ],200);

    }

    // Sort After Filter

    public function filterAfterSort(Request $request){
        $sort_by = null;
        $paginate = null;
        if ($request->has('sort_by')) {
            $sort_by = $request->sort_by;
        }
        if ($request->has('paginate')) {
            $paginate = $request->paginate;
        }
        if ($request->filterDataFromSeller) {
            $products = $this->sellerRepository->filterSortProductBlade($request->except("_token"),$request->filterDataFromSeller, $request->seller_id);
        }
        else {
            $products= $this->sellerRepository->getProduct($request->seller_id,$sort_by,$paginate);
        }

        return response()->json([
            'products' => $products,
            'message' => 'success'
        ],200);

    }

}
