<?php

namespace Modules\PaymentGateway\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use \Modules\PaymentGateway\Services\PaymentGatewayService;
use Brian2694\Toastr\Facades\Toastr;
use Modules\UserActivityLog\Traits\LogActivity;

class PaymentGatewayController extends Controller
{
    protected $paymentGatewayService;

    public function __construct(PaymentGatewayService  $paymentGatewayService)
    {
        $this->middleware('maintenance_mode');
        $this->paymentGatewayService = $paymentGatewayService;
    }


    public function index()
    {
        $data['gateway_activations'] = $this->paymentGatewayService->gateway_activations();
        if(!isModuleActive('Bkash')){
            $data['gateway_activations'] =  $data['gateway_activations']->filter(function($item) {
                if($item->method != 'Bkash'){
                    return $item->id;
                }
            });
        }
        return view('paymentgateway::index', $data);
    }



    public function configuration(Request $request)
    {
        try {
            $this->paymentGatewayService->update_gateway_credentials($request->except("_token"));
            LogActivity::successLog('payment gateway credential update successful.');
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            return back();
        }catch(\Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('error_message'));
            return redirect()->back();
        }
    }




    public function activation(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        try {
            $this->paymentGatewayService->update_activation($request->only('id', 'status'));
            LogActivity::successLog('payment activate successful.');
            $data['gateway_activations'] = $this->paymentGatewayService->gateway_activations();
            return response()->json([
                'status' => 1,
                'list' => (string)view('paymentgateway::components._all_config_form_list', $data)
            ]);
        }catch(\Exception $e){

            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'status' => 0
            ]);
        }
    }
}
