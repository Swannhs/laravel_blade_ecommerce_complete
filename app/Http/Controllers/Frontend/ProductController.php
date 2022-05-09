<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Traits\GoogleAnalytics4;
use Freshbitsweb\LaravelGoogleAnalytics4MeasurementProtocol\Facades\GA4;
use Illuminate\Http\Request;
use Modules\Seller\Entities\SellerProductSKU;
use DB;
use Modules\Seller\Entities\SellerProduct;

class ProductController extends Controller
{
    use GoogleAnalytics4;

    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        $this->middleware('maintenance_mode');
    }

    public function show($slug)
    {

        session()->forget('item_details');
          $product =  $this->productService->getActiveSellerProductBySlug($slug);

        if($product->status == 0 || $product->product->status == 0){
            return abort(404);
        }
        if (auth()->check()) {
            $this->productService->recentViewStore($product->id);
        }
        else {
            $recentViwedData = [];
            $recentViwedData['product_id'] = $product->id;

            if(session()->has('recent_viewed_products')){
                $recent_viewed_products = collect();

                foreach (session()->get('recent_viewed_products') as $key => $recentViwedItem){
                    $recent_viewed_products->push($recentViwedItem);
                }
                $recent_viewed_products->push($recentViwedData);
                session()->put('recent_viewed_products', $recent_viewed_products);
            }
            else{
                $recent_viewed_products = collect([$recentViwedData]);
                session()->put('recent_viewed_products', $recent_viewed_products);
            }
        }
        $this->productService->recentViewIncrease($product->id);
        $item_details = session()->get('item_details');
        $options = array();
        $data = array();
        if ($product->product->product_type == 2) {
            foreach ($product->variant_details as $key => $v) {
                $item_detail[$key] = [
                    'name' => $v->name,
                    'attr_id' => $v->attr_id,
                    'code' => $v->code,
                    'value' => $v->value,
                    'id' => $v->attr_val_id,
                ];
                array_push($data, $v->value);
            }

            if (!empty($item_details)) {
                session()->put('item_details', $item_details + $item_detail);
            } else{
                session()->put('item_details', $item_detail);
            }
        }
        $reviews = $product->reviews->where('status',1)->pluck('rating');
        if(count($reviews)>0){
            $value = 0;
            $rating = 0;
            foreach($reviews as $review){
                $value += $review;
            }
            $rating = $value/count($reviews);
            $total_review = count($reviews);
        }else{
            $rating = 0;
            $total_review = 0;
        }

        //ga4
        if(app('business_settings')->where('type', 'google_analytics')->first()->status == 1){
            $eData = [
                'name' => 'view_item',
                'params' => [
                    "currency" => currencyCode(),
                    "value"=> 1,
                    "items" => [
                        [
                            "item_id"=> $product->product->skus[0]->sku,
                            "item_name"=> $product->product_name,
                            "currency"=> currencyCode(),
                            "price"=> $product->product->skus[0]->selling_price
                        ]
                    ],
                ],
            ];

            $this->postEvent($eData);
        }
        //end ga4
        
        return view(theme('pages.product_details'),compact('product','rating','total_review'));
    }

    public function show_in_modal(Request $request)
    {
        session()->forget('item_details');
        $product =  $this->productService->getProductByID($request->product_id);
        $this->productService->recentViewIncrease($request->product_id);
        $item_details = session()->get('item_details');
        $options = array();
        $data = array();
        if ($product->product->product_type == 2) {
            foreach ($product->variant_details as $key => $v) {
                $item_detail[$key] = [
                    'name' => $v->name,
                    'attr_id' => $v->attr_id,
                    'code' => $v->code,
                    'value' => $v->value,
                    'id' => $v->attr_val_id,
                ];
                array_push($data, $v->value);
            }

            if (!empty($item_details)) {
                session()->put('item_details', $item_details + $item_detail);
            } else{
                session()->put('item_details', $item_detail);
            }
        }
        $reviews = $product->reviews->where('status',1)->pluck('rating');
        if(count($reviews)>0){
            $value = 0;
            $rating = 0;
            foreach($reviews as $review){
                $value += $review;
            }
            $rating = $value/count($reviews);
            $total_review = count($reviews);
        }else{
            $rating = 0;
            $total_review = 0;
        }
        return (string) view(theme('partials.product_add_to_cart_modal'),compact('product','rating','total_review'));
    }

    public function getReviewByPage(Request $request){
        $reviews = $this->productService->getReviewByPage($request->only('page', 'product_id'));
        return view(theme('partials._product_review_with_paginate'),compact('reviews'));
    }
}
