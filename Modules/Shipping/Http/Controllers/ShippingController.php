<?php

namespace Modules\Shipping\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Shipping\Services\ShippingService;
use Modules\Shipping\Http\Requests\CreateShippingRequest;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Modules\Shipping\Http\Requests\UpdateShippingRequest;
use Modules\UserActivityLog\Traits\LogActivity;

class ShippingController extends Controller
{
    protected $shippingService;

    public function __construct(ShippingService  $shippingService)
    {
        $this->middleware('maintenance_mode');
        $this->shippingService = $shippingService;
    }

    public function index()
    {
        $data['methods'] = $this->shippingService->getAll();
        return view('shipping::shipping_methods.index', $data);
    }

    public function store(CreateShippingRequest $request)
    {
        try {
            $this->shippingService->store($request->except("_token"));
            LogActivity::successLog('New Shipping method added');
            Toastr::success(__('common.added_successfully'),__('common.success'));
            if(isset($request->form_type)){
                if($request->form_type == 'modal_form'){
                    $shippings = $this->shippingService->getActiveAll();
                    return view('product::products.components._shipping_method_list_select',compact('shippings'));
                }else{
                    return $this->reloadWithData();
                }
            }else{
                return $this->reloadWithData();
            }


        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

    public function edit($id)
    {
        $shipping_method = $this->shippingService->findById($id);
        return view('shipping::shipping_methods.components._edit',compact('shipping_method'));
    }

    public function update(UpdateShippingRequest $request)
    {

        try {
            $this->shippingService->update($request->except("_token"), $request->id);
            LogActivity::successLog('Shipping method Updated');
            Toastr::success(__('common.updated_successfully'),__('common.success'));
            return $this->reloadWithData();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }


    public function destroy(Request $request)
    {
        try {
            $result = $this->shippingService->delete($request->id);
            if ($result == "not_possible") {
                return response()->json([
                    'msg' => __('common.related_data_exist_in_multiple_directory')
                ]);
            }
            LogActivity::successLog('Shipping Method has been destroyed.');
            return $this->reloadWithData();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }


    public function update_status(Request $request)
    {
        try {
            $this->shippingService->updateStatus($request->except("_token"));
            return 1;
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return 0;
        }
    }

    public function update_approve_status(Request $request)
    {
        try {
            $this->shippingService->updateApproveStatus($request->except("_token"));
            return 1;
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return 0;
        }
    }

    private function reloadWithData(){
        try{
            if (auth()->user()->role->type == 'seller') {
                $data['unapproved_shipping_methods'] = $this->shippingService->getRequestedSellerOwnShippingMethod();
                return response()->json([
                    'TableData' =>  (string)view('seller::setting.components.requested_shipping', $data),
                ],200);
            }
            else {
                $methods = $this->shippingService->getAll();
                return response()->json([

                    'TableData' =>  (string)view('shipping::shipping_methods.components._method_list', compact('methods')),
                    'createForm' =>  (string)view('shipping::shipping_methods.components._create')
                ],200);
            }
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }
}
