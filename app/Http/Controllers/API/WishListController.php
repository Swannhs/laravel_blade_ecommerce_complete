<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\WishlistService;

class WishListController extends Controller
{

    protected $wishlistService;

    public function __construct(WishlistService $wishlistService){
        $this->wishlistService = $wishlistService;
    }

    // Wish list
    public function index(Request $request){

        $products = $this->wishlistService->myWishlistAPI($request->user()->id);
        if(count($products) > 0){
            return response()->json([
                'products' => $products,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'wishlist is empty'
            ],404);
        }
    }

    // Store

    public function store(Request $request){
        $request->validate([
            'seller_id' => 'required',
            'seller_product_id' => 'required',
            'type' => 'required'
        ]);

        $product = $this->wishlistService->store($request->except('_token'), $request->user());
        if($product == 1){
            return response()->json([
                'message' => 'Product added to wishlist.'
            ],201);
        }elseif($product == 3){
            return response()->json([
                'message' => 'Product already in wishlist'
            ],409);
        }else{
            return response()->json([
                'message' => 'something gone wrong'
            ],500);
        }
    }

    // Delete

    public function destroy(Request $request){
        $request->validate([
            'id' => 'required'
        ]);

        $result = $this->wishlistService->remove($request->id, $request->user()->id);
        if($result){
            return response()->json([
                'message' => 'product removed from wishlist successfully.'
            ],202);
        }else{
            return response()->json([
                'message' => 'product not found'
            ],404);
        }
    }
}
