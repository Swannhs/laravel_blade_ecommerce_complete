<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Seller\Entities\SellerProduct;
use App\Repositories\ProductRepository;
use Modules\UserActivityLog\Traits\LogActivity;

class SearchController extends Controller
{
    public function liveSearch(Request $request){
        $request->validate([
            'cat_id' => 'required',
            'keyword' => 'required'
        ]);
        try {
            $productService = new ProductRepository(new SellerProduct);
            $data = $productService->searchProduct($request->all());
            return response()->json($data,200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }
}
