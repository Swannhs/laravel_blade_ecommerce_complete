<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderCreateRequest;
use App\Models\Order;
use App\Models\OrderPackageDetail;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Refund\Entities\RefundRequest;
use App\Services\ProductReviewService;
use Modules\Refund\Repositories\RefundReasonRepository;
use Modules\Refund\Services\RefundService;
use Modules\Shipping\Repositories\ShippingRepository;


class OrderController extends Controller
{
    protected $orderService;
    protected $productReviewService;
    protected $refundService;

    public function __construct(OrderService $orderService, ProductReviewService $productReviewService, RefundService $refundService)
    {
        $this->orderService = $orderService;
        $this->productReviewService = $productReviewService;
        $this->refundService = $refundService;
    }

    // All Order list    
    public function allOrderList(Request $request){

        $orders = Order::with('customer', 'packages','packages.seller','packages.delivery_states', 'shipping_address','billing_address', 'packages.products','packages.products.seller_product_sku.product.product',
        'packages.products.seller_product_sku.product_variations.attribute','packages.products.seller_product_sku.product_variations.attribute_value.color','packages.products.giftCard','packages.products.seller_product_sku.sku')->where('customer_id', $request->user()->id)->latest()->get();
        
        if(count($orders) > 0){
            return response()->json([
                'orders' => $orders,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'order not found'
            ]);
        }

    }
    

    
    // Pending Order list
    public function PendingOrderList(Request $request){

        $orders = Order::with('customer', 'packages','packages.seller','packages.delivery_states', 'shipping_address','billing_address', 'packages.products','packages.products.seller_product_sku.product.product','packages.products.seller_product_sku.product_variations.attribute','packages.products.seller_product_sku.product_variations.attribute_value.color','packages.products.giftCard', 'packages.products.seller_product_sku.sku')->where('customer_id', $request->user()->id)->where('is_confirmed', 0)->latest()->get();
        if(count($orders) > 0){
            return response()->json([
                'orders' => $orders,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'order not found'
            ]);
        }
    }

    // Cancel Order list

    public function cancelOrderList(Request $request){

        $orders = Order::with('customer', 'packages','packages.seller','packages.delivery_states', 'shipping_address','billing_address', 'packages.products','packages.products.seller_product_sku.product.product','packages.products.seller_product_sku.product_variations.attribute','packages.products.seller_product_sku.product_variations.attribute_value.color','packages.products.giftCard', 'packages.products.seller_product_sku.sku')->where('customer_id', $request->user()->id)->where('is_cancelled', 1)->latest()->get();
        if(count($orders) > 0){
            return response()->json([
                'orders' => $orders,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'order not found'
            ]);
        }
    }

    // Order To Ship
    public function orderToShip(Request $request){
        $packages = $this->orderService->getOrderToShip($request->user()->id);

        if(count($packages) > 0){
            return response()->json([
                'packages' => $packages,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'package not found'
            ],404);
        }
    }

    // Order To Receive

    public function orderToReceive(Request $request){
        $packages = $this->orderService->getOrderToReceive($request->user()->id);
        if(count($packages) > 0){
            return response()->json([
                'packages' => $packages,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'package not found'
            ],404);
        }
    }

    // Order Store
    public function orderStore(OrderCreateRequest $request){

        DB::beginTransaction();
        try{
            $order = $this->orderService->orderStoreForAPI($request->user(), $request->except('_token'));
            DB::commit();
            return response()->json([
                'message' => 'order created successfully'
            ],201);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'something gone wrong'
            ], 503);
        }
        

    }

    // Single Order

    public function singleOrder(Request $request, $order_number){

        $order = Order::with('customer', 'packages', 'packages.seller','packages.delivery_states', 'shipping_address','billing_address', 'packages.products','packages.products.seller_product_sku.product.product','packages.products.seller_product_sku.product_variations.attribute','packages.products.seller_product_sku.product_variations.attribute_value.color','packages.products.giftCard', 'packages.products.seller_product_sku.sku')->where('customer_id', $request->user()->id)->where('order_number', $request->order_number)->first();
        if($order){
            return response()->json([
                'order' => $order,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'order not found'
            ],404);
        }
    }

    // Refund Order List

    public function refundOrderList(Request $request){
        $refundOrders = RefundRequest::with('order','shipping_gateway','pick_up_address_customer','refund_details','refund_details.order_package','refund_details.seller',
        'refund_details.process_refund','refund_details.refund_products','refund_details.refund_products.seller_product_sku','refund_details.refund_products.seller_product_sku.product_variations.attribute','refund_details.refund_products.seller_product_sku.product_variations.attribute_value.color','refund_details.refund_products.seller_product_sku.product',
        'refund_details.refund_products.seller_product_sku.product.product')
        ->where('customer_id', $request->user()->id)->latest()->get();

        if(count($refundOrders) > 0){
            return response()->json([
                'refundOrders' => $refundOrders,
                'message' => 'success'
            ], 200);
        }else{
            return response()->json([
                'message' => 'not found'
            ]);
        }

    }

    // Order Track

    public function orderTrack(Request $request){

        $user = $request->user();
        $request->validate([
            'order_number' => 'required',
            'secret_id' => (!$user) ? 'required' : 'nullable',
            'phone' => ($user) ? 'required' : 'nullable',
        ]);
        try {
            if($user){
                $data['order'] = $this->orderService->orderFindByOrderNumber($request->except('_token'), $user);
            }else{
                $data['order'] = $this->orderService->orderFindByOrderNumber($request->except('_token'), null);
            }
            
            if ($data['order'] == "Invalid Tracking ID") {
                
                return response()->json([
                    'message' => $data['order'] 
                ],200);
            }
            elseif ($data['order'] == "Invalid Secret ID") {
                return response()->json([
                    'message' => $data['order'] 
                ],200);
            }
            elseif ($data['order'] == "Phone Number didn't match") {
                return response()->json([
                    'message' => $data['order'] 
                ],409);
            }
            else {

                return response()->json([
                    'order' => $data['order'],
                    'message' => 'success'
                ],200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'something gone wrong'
            ],503);
        }
    }

    // Order Review Package wise
    public function OrderReviewPackageWise(Request $request){
        $request->validate([
            'seller_id' => 'required',
            'package_id' => 'required',
            'order_id' => 'required',
        ]);
        $package = OrderPackageDetail::with('order','products','shipping','gst_taxes','seller','delivery_process','delivery_states','reviews','products.seller_product_sku.product.product','products.seller_product_sku.product_variations.attribute','products.seller_product_sku.product_variations.attribute_value.color')
            ->where('id', $request->package_id)->where('order_id', $request->order_id)->where('seller_id', $request->seller_id)->first();
        if($package){
            return response()->json([
                'package' => $package,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'not found'
            ],404);
        }
    }

    // Order Review Store

    public function OrderReview(Request $request){

        $request->validate([
            'product_id' =>'required',
            'product_review' => 'required',
            'seller_id' => 'required',
            'order_id' => 'required',
            'package_id' => 'required',
            'seller_rating' => 'required',
            'seller_review' => 'required',
            'product_type' => 'required'
        ]);


        DB::beginTransaction();
        try{
            $review = $this->productReviewService->store($request->except('_token'), $request->user());
            if($review){
                DB::commit();

                return response()->json([
                    'message' => 'Review Done. Thanks for Review.'
                ],201);
            }else{
                return response()->json([
                    'message' => 'Review already exsist'
                ],409);
            }

        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'something gone wrong'
            ],503);
        }

    }

    // Waiting for review list

    public function waitingForReview(Request $request){
        
        $packages = $this->productReviewService->waitingForReview($request->user());
        if(count($packages) > 0){
            return response()->json([
                'packages' => $packages,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'package not found'
            ],404);
        }
    }

    // Review list

    public function reviewList(Request $request){
        $reviews = $this->productReviewService->reviewList($request->user()->id);

        if(count($reviews) > 0){
            return response()->json([
                'reviews' => $reviews,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'package not found'
            ],404);
        }
    }

    // Make Refund Page data

    public function makeRefundData(Request $request, $id){

        $orderRepo = new OrderRepository;
        $refundReasonRepo = new RefundReasonRepository;
        $shippingService = new ShippingRepository;
        $data['order'] = $orderRepo->orderFindByID($id);
        $data['shipping_methods'] = $shippingService->getActiveAll();
        $data['reasons'] = $refundReasonRepo->getAll();

        if($data['order']){
            return response()->json($data, 200);
        }else{
            return response()->json([
                'message' => 'order not found'
            ],404);
        }
        
    }


    // Refund Store

    public function refundStore(Request $request){

        $request->validate([
            'order_id' => 'required',
            'product_ids' => 'required',
            'money_get_method' => 'required',
            'shipping_way' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $refund =  $this->refundService->store($request->except("_token"), $request->user());
            DB::commit();
            if($refund){
                return response()->json([
                    'message' => 'refund successfully'
                ],201);
            }else{
                return response()->json([
                    'message' => 'refund not complete. something gone wrong'
                ],500);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'something gone wrong'
            ],500);

        }
    }


    // Payment info store

    public function paymentInfoStore(Request $request){
        $request->validate([
            'amount' => 'required',
            'transection_id' => 'required',
            'payment_method' => 'required'
        ]);

        $order_repo = new OrderRepository;
        $payment = $order_repo->orderPaymentDone($request->amount,$request->payment_method , $request->transection_id, $request->user());

        return response()->json([
            'payment_info' => $payment,
            'message' => 'payment successfull'
        ], 201);

    }



}
