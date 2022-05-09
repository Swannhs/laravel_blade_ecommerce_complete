<?php

namespace Modules\InhouseOrder\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\InhouseOrder\Services\InhouseOrderService;
use Exception;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\SendMail;
use Modules\Setup\Repositories\StateRepository;
use Modules\Setup\Repositories\CityRepository;
use Modules\UserActivityLog\Traits\LogActivity;

class InhouseOrderController extends Controller
{
    use SendMail;

    protected $inhouseOrderService;
    public function __construct(InhouseOrderService $inhouseOrderService)
    {
        $this->middleware('maintenance_mode');
        $this->inhouseOrderService = $inhouseOrderService;
    }

    public function index()
    {
        try{
            return view('inhouseorder::inhouse_order.index');

        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error(__('common.Something Went Wrong'));
            return redirect()->back();
        }
    }

    public function getData(){
        if(isset($_GET['table'])){
            $table = $_GET['table'];

            if($table == 'confirmed'){
                $order = $this->inhouseOrderService->inhouseOrderList()->where('is_confirmed', 1);
            }
            elseif($table == 'completed'){
                $order = $this->inhouseOrderService->inhouseOrderList()->where('is_completed', 1);
            }
            elseif($table == 'pending_payment'){
                $order = $this->inhouseOrderService->inhouseOrderList()->where('is_paid', 0);
            }
            elseif($table == 'canceled'){
                $order = $this->inhouseOrderService->inhouseOrderList()->where('is_cancelled', 1);
            }
            elseif($table == 'all'){
                $order = $this->inhouseOrderService->inhouseOrderList();
            }
            else{
                $order = [];
            }

            return DataTables::of($order)
            ->addIndexColumn()
            ->addColumn('date', function($order){
                return date(app('general_setting')->dateFormat->format, strtotime($order->created_at));
            })
            ->addColumn('email', function($order){
                return ($order->customer_id) ? @$order->customer->email : @$order->guest_info->shipping_email;;

            })
            ->addColumn('total_qty', function($order){
                return $order->packages->sum('number_of_product');
            })
            ->addColumn('total_amount',function($order){
                return single_price($order->grand_total);

            })
            ->addColumn('order_status', function($order){
                return view('ordermanage::order_manage.components._order_status_td',compact('order'));
            })
            ->addColumn('is_paid', function($order){
                return view('ordermanage::order_manage.components._is_paid_td',compact('order'));
            })
            ->addColumn('action',function($order) use($table){
                return view('ordermanage::order_manage.components._action_td',compact('order','table'));
            })
            ->rawColumns(['order_status','is_paid','action'])
            ->make(true);
        }else{
            return [];
        }
    }


    public function create(){
        try{
            $data['products'] = $this->inhouseOrderService->getProducts();
            $data['countries'] = $this->inhouseOrderService->getCountries();
            $data['states'] = (new StateRepository())->getByCountryId(app('general_setting')->default_country)->where('status', 1);
            $data['cities'] = (new CityRepository())->getByStateId(app('general_setting')->default_state)->where('status', 1);
            $data['cartData'] = $this->inhouseOrderService->getInhouseCartData();
            $data['paymentMethod'] = $this->inhouseOrderService->getPaymentMethods();
            return view('inhouseorder::inhouse_order.create',$data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }

    public function store(Request $request){

        DB::beginTransaction();
        try{
            $order = $this->inhouseOrderService->store($request->except('_token'));
            DB::commit();
            if (app('business_settings')->where('type', 'mail_notification')->first()->status == 1) {
                $this->sendInvoiceMail($order->order_number, $order);
            }
            LogActivity::successLog('order created successful.');
            Toastr::success(__('common.created_successfully'),__('common.success'));
            return redirect()->route('admin.inhouse-order.index');

        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error(__('common.error_message'));
            return redirect()->back();
        }

    }

    public function getProductVariant(Request $request){

        try{
            $product_type = $this->inhouseOrderService->productTypeCheck($request->product_id);


            if($product_type == 'variant_product'){
                session()->forget('item_details');
                
                $product = $this->inhouseOrderService->getVariantByProduct($request->product_id);
                
                
                $reviews = $product->reviews->where('status',1)->pluck('rating');
                if(count($reviews) > 0){
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

                $item_details = session()->get('item_details');
                $options = array();
                $data = array();

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

                return response()->json([
                    'modalData' =>  (string)view('inhouseorder::inhouse_order.components._product_variant_modal', compact('product','rating','total_review')),
                    'productType' =>  $product_type
                ],200);
            }else{
                $result = $this->inhouseOrderService->addToCart($request->product_id);

                if($result == 'out_of_stock'){
                    return 'out_of_stock';
                }else{
                    return $this->reloadWithPackageData();
                }

            }

        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }

    }

    public function addToCart(Request $request){

        try{
            $result = $this->inhouseOrderService->storeVariantProductToCart($request->except('_token'));
            if($result == 'out_of_stock'){
                return 'out_of_stock';
            }else{
                LogActivity::successLog('add to cart successful.');
                return $this->reloadWithPackageData();
            }
            
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }

    }

    public function destroy(Request $request){
        try{
            $this->inhouseOrderService->deleteById($request->id);
            LogActivity::successLog('order deleted successful.');
            return $this->reloadWithPackageData();

        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }

    }


    private function reloadWithPackageData(){
        try{
            $cartData = $this->inhouseOrderService->getInhouseCartData();
            $countries = $this->inhouseOrderService->getCountries();
            $states = (new StateRepository())->getByCountryId(app('general_setting')->default_country)->where('status', 1);
            $cities = (new CityRepository())->getByStateId(app('general_setting')->default_state)->where('status', 1);

            return response()->json([
                'PackageData' => (string)view('inhouseorder::inhouse_order.components._product_by_package', compact('cartData')),
                'productType' =>  'empty',
                'address' => (string)view('inhouseorder::inhouse_order.components._address',compact('countries','states','cities'))
            ],200);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

    public function changeShippingMethod(Request $request){
        try{
            $this->inhouseOrderService->changeShippingMethod($request->except('_token'));
            LogActivity::successLog('shipping method changed successful.');
            return $this->reloadWithPackageData();

        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }

    }

    public function changeQty(Request $request){

        try{
            $this->inhouseOrderService->changeQty($request->except('_token'));
            LogActivity::successLog('Qty changed successful.');
            return $this->reloadWithPackageData();

        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }

    }

    public function addressSave(Request $request){
        try{
            $this->inhouseOrderService->addressSave($request->except('_token'));
            LogActivity::successLog('address saved successful.');
            return $this->reloadWithPackageData();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }


    }

    public function resetAddress(){
        try{
            $this->inhouseOrderService->resetAddress();
            LogActivity::successLog('address reset successful.');
            return $this->reloadWithPackageData();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }

    }
}
