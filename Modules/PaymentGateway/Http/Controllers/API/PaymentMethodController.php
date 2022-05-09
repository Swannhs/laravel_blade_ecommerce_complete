<?php

namespace Modules\PaymentGateway\Http\Controllers\API;

use App\Repositories\OrderRepository;
use App\Traits\ImageStore;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\PaymentGateway\Services\PaymentGatewayService;
use Modules\PaymentGateway\Transformers\PaymentMethodResource;
use Modules\Wallet\Entities\BankPayment;


class PaymentMethodController extends Controller
{
    use ImageStore;

    protected $paymentGatewayService;

    public function __construct(PaymentGatewayService $paymentGatewayService)
    {
        $this->paymentGatewayService = $paymentGatewayService;
    }

    // Pament Gateway List
    public function index(){
        $gateway_activations = $this->paymentGatewayService->gateway_activations();
        return PaymentMethodResource::collection($gateway_activations);
    }

    // Single Payment Gateway

    public function show($id){
        $payment_method = $this->paymentGatewayService->findById($id);
        if($payment_method){
            return new PaymentMethodResource($payment_method);
        }else{
            return response()->json([
                'message' => 'not found'
            ], 404);
        }
    }
    
    // Bank Payment info

    public function getBankInfo(){
        $bank_info = [
            'bank_name' => env('BANK_NAME'),
            'branch_name' => env('BRANCH_NAME'),
            'account_number' => env('ACCOUNT_NUMBER'),
            'account_holder' => env('ACCOUNT_HOLDER')
        ];

        return response()->json([
            'bank_info' => $bank_info,
            'message' => 'success'
        ], 200);
    }

    // bank payment data store

    public function bankPaymentDataStore(Request $request){
        $request->validate([
            'payment_for' => 'required',
            'bank_name' => 'required',
            'payment_method' => 'required',
            'branch_name' => 'required',
            'account_number' => 'required',
            'account_holder' => 'required'
        ]);

        if(isset($request->image)){
            $image = $this->saveImage($request->image);
        }
        $bank_payment = BankPayment::create([
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'account_number' => $request->account_number,
            'account_holder' => $request->account_holder,
            'image_src' => isset($request->image)?$image:null
        ]);

        if($request->payment_for == 'order_payment'){

            $order_paymentRepo = new OrderRepository;
            $order_payment = $order_paymentRepo->orderPaymentDone($request->bank_amount, 7, "none", $request->user());
            return response()->json([
                'payment_info' => $order_payment,
                'bank_details' => $bank_payment,
                'message' => 'success'
            ], 201);
        }
    }

}
