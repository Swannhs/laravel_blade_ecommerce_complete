<?php

namespace Modules\OrderManage\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\OrderManage\Services\OrderManageService;
use Modules\GiftCard\Services\GiftCardService;
use Modules\GiftCard\Repositories\GiftCardRepository;
use Modules\OrderManage\Repositories\DeliveryProcessRepository;
use Brian2694\Toastr\Facades\Toastr;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Modules\UserActivityLog\Traits\LogActivity;

class OrderManageController extends Controller
{
    protected $ordermanageService;

    public function __construct(OrderManageService $ordermanageService)
    {
        $this->middleware('maintenance_mode');
        $this->ordermanageService = $ordermanageService;
    }

    public function index()
    {
        return view('ordermanage::index');
    }

    public function my_sales_index()
    {
        return view('ordermanage::order_manage.my_orders');
    }

    public function my_sales_get_data()
    {
        if (isset($_GET['table'])) {
            $table = $_GET['table'];
            if ($table == 'pending_payment') {
                $order_package = $this->ordermanageService->myPendingPaymentSalesList();
            } elseif ($table == 'confirmed') {
                $order_package = $this->ordermanageService->myConfirmedSalesList();
            } elseif ($table == 'completed') {
                $order_package = $this->ordermanageService->myCompletedSalesList();
            } elseif ($table == 'canceled') {
                $order_package = $this->ordermanageService->myCancelledPaymentSalesList();
            } else {
                $order_package = [];
            }

            return DataTables::of($order_package)
                ->addIndexColumn()
                ->addColumn('date', function ($order_package) {
                    return date(app('general_setting')->dateFormat->format, strtotime($order_package->order->created_at));
                })
                ->addColumn('order_number', function ($order_package) {
                    return @$order_package->order->order_number;
                })
                ->addColumn('email', function ($order_package) {
                    return ($order_package->order->customer_id) ? @$order_package->order->customer->email : @$order_package->order->guest_info->shipping_email;
                })
                ->addColumn('order_state', function ($order_package) {
                    return view('ordermanage::order_manage.components._my_order_order_state_td', compact('order_package'));
                })
                ->addColumn('total_amount', function ($order_package) {
                    return single_price($order_package->products->sum('total_price') + $order_package->shipping_cost + $order_package->tax_amount);
                })
                ->addColumn('order_status', function ($order_package) {
                    return view('ordermanage::order_manage.components._my_order_status_td', compact('order_package'));
                })
                ->addColumn('action', function ($order_package) {
                    return view('ordermanage::order_manage.components._my_order_action_td', compact('order_package'));
                })
                ->rawColumns(['order_status', 'is_paid', 'action'])
                ->toJson();
        }
    }


    public function total_sales_index()
    {
        return view('ordermanage::order_manage.total_sales');
    }

    public function total_sales_get_data()
    {

        if (isset($_GET['table'])) {
            $table = $_GET['table'];
            if ($table == 'pending') {
                $order = $this->ordermanageService->totalSalesList()->where('is_confirmed', 0)->where('is_cancelled', 0);
            } elseif ($table == 'confirmed') {
                $order = $this->ordermanageService->totalSalesList()->where('is_confirmed', 1)->where('is_cancelled', 0)->where('is_completed', 0);
            } elseif ($table == 'completed') {
                $order = $this->ordermanageService->totalSalesList()->where('is_completed', 1)->where('is_cancelled',0);
            } elseif ($table == 'pending_payment') {
                $order = $this->ordermanageService->totalSalesList()->where('is_paid', 0)->where('is_cancelled', 0);
            } elseif ($table == 'canceled') {
                $order = $this->ordermanageService->totalSalesList()->where('is_cancelled', 1);
            } elseif ($table == 'inhouse') {
                $order = $this->ordermanageService->totalSalesList()->where('order_type', 'inhouse_order');
            } elseif ($table == 'all') {
                $order = $this->ordermanageService->totalSalesList();
            } else {
                $order = [];
            }

            return DataTables::of($order)
                ->addIndexColumn()
                ->addColumn('date', function ($order) {
                    return date(app('general_setting')->dateFormat->format, strtotime($order->created_at));
                })
                ->addColumn('email', function ($order) {
                    return ($order->customer_id) ? @$order->customer->email : @$order->guest_info->shipping_email;;
                })
                ->addColumn('total_qty', function ($order) {
                    // return $order->packages->products->sum('qty');
                    $count = 0;
                    foreach($order->packages as $key => $package){
                        foreach($package->products as $product){
                            $count  += $product->qty;
                        }
                    }
                    return $count;

                })
                ->addColumn('total_amount', function ($order) {
                    return single_price($order->grand_total);
                })
                ->addColumn('order_status', function ($order) {
                    return view('ordermanage::order_manage.components._order_status_td', compact('order'));
                })
                ->addColumn('is_paid', function ($order) {
                    return view('ordermanage::order_manage.components._is_paid_td', compact('order'));
                })
                ->addColumn('action', function ($order) use($table) {
                    return view('ordermanage::order_manage.components._action_td', compact('order', 'table'));
                })
                ->rawColumns(['order_confirm','order_status', 'is_paid', 'action'])
                ->make(true);
        } else {
            return [];
        }
    }



    public function show($id)
    {
        $data['order'] = $this->ordermanageService->findOrderByID($id);
        return view('ordermanage::order_manage.sale_details', $data);
    }


    public function my_sale_show($id)
    {
        $data['package'] = $this->ordermanageService->findOrderPackageByID($id);
        $data['order'] = $this->ordermanageService->findOrderByID($data['package']->order_id);
        $orderDeliveryRepo = new DeliveryProcessRepository;
        $data['processes'] = $orderDeliveryRepo->getAll();
        return view('ordermanage::order_manage.my_sale_details', $data);
    }


    public function my_sale_show_for_refund($id)
    {
        $data['order'] = $this->ordermanageService->findOrderByID($id);
        $orderDeliveryRepo = new DeliveryProcessRepository;
        $data['processes'] = $orderDeliveryRepo->getAll();
        return view('ordermanage::order_manage.my_sale_details', $data);
    }


    public function sales_info_update(Request $request, $id)
    {
        $data['order'] = $this->ordermanageService->orderInfoUpdate($request->except("_token"), $id);
            if ($data['order'] ==  false) {

                Toastr::warning(__('order.please_create_account_for_deposite_main_income_seller_income_product_wise_tax_and_gst_tax'));
                return back();
            }
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('sales info update successful.');
            return back();

        try {
            $data['order'] = $this->ordermanageService->orderInfoUpdate($request->except("_token"), $id);
            if ($data['order'] ==  false) {

                Toastr::warning(__('order.please_create_account_for_deposite_main_income_seller_income_product_wise_tax_and_gst_tax'));
                return back();
            }
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('sales info update successful.');
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));

            return back();
        }
    }

    public function update_delivery(Request $request, $id)
    {
        try {
            $data['order'] = $this->ordermanageService->updateDeliveryStatus($request->except("_token"), $id);
            Toastr::success(__('common.status_updated_successfully'), __('common.success'));
            LogActivity::successLog('delivery update successful.');
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'));
            return back();
        }
    }

    public function change_delivery_status_by_customer(Request $request)
    {
        try {
            $this->ordermanageService->updateDeliveryStatusRecieve($request->package_id);
            LogActivity::successLog('delivery status change by customer successful.');
            return 1;
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return 0;
        }
    }

    public function globalPrint($id)
    {
        $data['order'] = $this->ordermanageService->findOrderByID($id);

        return view('ordermanage::order_manage.sale_print', $data);

    }

    public function personalPrint($id)
    {
        $data['order'] = $this->ordermanageService->findOrderByID($id);
        return view('ordermanage::order_manage.my_sale_print', $data);

    }

    public function send_gift_card_code(Request $request)
    {
        try {
            $giftCardService = new GiftCardService(new GiftCardRepository());
            $response = $giftCardService->send_code_to_mail($request->except('_token'));
            LogActivity::successLog('Send gift card code successful.');
            return $response;
        } catch (\Exception $e) {
            
            LogActivity::errorLog($e->getMessage());
            return false;
        }
    }

    public function send_digital_file_access(Request $request)
    {
        try {
            DB::beginTransaction();
            $response = $this->ordermanageService->sendDigitalFileAccess($request->except("_token"));
            if ($response == false) {
                DB::rollBack();
            } else {
                DB::commit();
            }
            LogActivity::successLog('Send digital file access successful.');
            return $response;
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            return false;
        }
    }

    public function download($slug)
    {
        try {
            $response = $this->ordermanageService->DigitalFileDownload($slug);
            return redirect()->to($response);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }

    public function orderConfirm($id){
        $result = $this->ordermanageService->orderConfirm($id);
        if($result == 'done'){
            Toastr::success(__('common.status_updated_successfully'), __('common.success'));
        }else{
            Toastr::error(__('common.error_message'), __('common.error'));
        }
        return redirect()->back();
    }


    public function track_order_configuration()
    {
        try {
            $trackOrderConfiguration = $this->ordermanageService->getTrackOrderConfiguration();
            return view('ordermanage::track_order_configuration', compact('trackOrderConfiguration'));
        } catch (\Exception $e) {
            Toastr::error(__('common.operation_failed'));
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }

    public function track_order_configuration_update(Request $request)
    {
        try {
            $this->ordermanageService->trackOrderConfigurationUpdate($request);
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('track order configuration updated.');
            return back();
        } catch (\Exception $e) {
            Toastr::error(__('common.operation_failed'));
            LogActivity::errorLog($e->getMessage());
            return back();
        }

    }

    public function getPackageInfo(Request $request){
        $package = $this->ordermanageService->getPackageInfo($request->id);
        return view('ordermanage::order_manage.components._modal_for_package_manage',compact('package'));
    }
}
