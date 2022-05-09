<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Services\ProductService;
use Brian2694\Toastr\Facades\Toastr;
use Exception;

class RequestProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->middleware('maintenance_mode');
        $this->productService = $productService;
    }

    public function index()
    {
        try {
            $productRequests = $this->productService->getRequestProduct();
            return view('product::products.request_product', compact('productRequests'));
        } catch (Exception $e) {
            \LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function approved(Request $request)
    {

        try {
            $this->productService->productApproved($request->except('_token'));
            \LogActivity::successLog('request approve successful.');
        } catch (Exception $e) {
            \LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
        return $this->loadTableData();
    }

    private function loadTableData()
    {

        try {
            $products = $this->productService->getRequestProduct();

            return response()->json([
                'TableData' =>  (string)view('product::products.request_product_list', compact('products'))
            ]);
        } catch (\Exception $e) {
            \LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }
}
