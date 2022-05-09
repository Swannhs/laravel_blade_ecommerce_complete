<?php

namespace Modules\Refund\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Refund\Services\RefundService;
use Modules\Refund\Repositories\RefundReasonRepository;
use Modules\Refund\Repositories\RefundProcessRepository;
use Modules\Shipping\Repositories\ShippingRepository;
use App\Repositories\OrderRepository;
use \Modules\GeneralSetting\Repositories\GeneralSettingRepository;
use Brian2694\Toastr\Facades\Toastr;
use Modules\UserActivityLog\Traits\LogActivity;
use Yajra\DataTables\Facades\DataTables;

class RefundController extends Controller
{
    protected $refundService;

    public function __construct(RefundService $refundService)
    {
        $this->middleware('maintenance_mode');
        $this->refundService = $refundService;
    }

    public function all_refund_request_index()
    {
        return view('refund::admin.refund_requests.index');
    }

    public function all_refund_request_data(Request $request)
    {
        $data = $this->refundService->getRequestAll();
        if ($request->table == 'confirmed') {
            $data = $data->where('is_confirmed', 1);
        } else {
            $data = $data->where('is_confirmed', 0);
        }
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('date', function ($data) {
                return date(app('general_setting')->dateFormat->format, strtotime($data->created_at));
            })
            ->addColumn('email', function ($data) {
                return $data->customer->email;
            })
            ->addColumn('order_id', function ($data) {
                return $data->order->order_number;
            })
            ->addColumn('total_amount', function ($data) {
                return single_price($data->total_return_amount);
            })
            ->addColumn('request_status', function ($data) {
                if ($data->is_confirmed == 1)
                    return '<h6><span class="badge_1">' . __("common.confirmed") . '</span></h6>';
                elseif ($data->is_confirmed == 2)
                    return '<h6><span class="badge_4">' . __("common.declined") . ' </span></h6>';
                else
                    return '<h6><span class="badge_4">' . __("common.pending") . ' </span></h6>';
            })
            ->addColumn('is_refunded', function ($data) {
                if ($data->is_refunded == 1)
                    return '<h6><span class="badge_1">' . __('common.refunded') . '</span></h6>';
                else
                    return '<h6><span class="badge_4">' . __('common.pending') . '</span></h6>';
            })
            ->addColumn('action', function ($data) {
                return view('refund::admin.refund_requests.components.refund_action_td', compact('data'));
            })
            ->rawColumns(['request_status', 'is_refunded', 'action'])
            ->toJson();
    }

    public function all_refund_request_confirmed_index()
    {
        return view('refund::admin.refund_requests.confirmed_index');
    }

    public function seller_refund_request_list()
    {
         $refund_request_details = $this->refundService->getRequestSeller();
        return view('refund::seller.refund_requests.index',compact('refund_request_details'));
    }


    public function seller_refund_request_data()
    {
        $data = $this->refundService->getRequestSeller();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('date', function ($data) {
                return date(app('general_setting')->dateFormat->format, strtotime($data->refund_request->created_at));
            })
            ->addColumn('email', function ($data) {
                return $data->refund_request->customer->email;
            })
            ->addColumn('order_id', function ($data) {
                return $data->refund_request->order->order_number;
            })
            ->addColumn('total_amount', function ($data) {
                return single_price($data->refund_request->total_return_amount);
            })
            ->addColumn('request_status', function ($data) {
                if ($data->refund_request->is_confirmed == 1)
                    return '<h6><span class="badge_1">' . __("common.confirmed") . '</span></h6>';
                elseif ($data->refund_request->is_confirmed == 2)
                    return '<h6><span class="badge_4">' . __("common.declined") . ' </span></h6>';
                else
                    return '<h6><span class="badge_4">' . __("common.pending") . ' </span></h6>';
            })
            ->addColumn('is_refunded', function ($data) {
                if ($data->is_refunded == 1)
                    return '<h6><span class="badge_1">' . __('common.refunded') . '</span></h6>';
                else
                    return '<h6><span class="badge_4">' . __('common.pending') . '</span></h6>';
            })
            ->addColumn('action', function ($data) {
                return view('refund::seller.refund_requests.refund_action_td', compact('data'));
            })
            ->rawColumns(['request_status', 'is_refunded', 'action'])
            ->toJson();
    }


    public function my_refund_index()
    {
        $data['my_refund_items'] = $this->refundService->getRequestForCustomer();
        if (auth()->user()->role->type != 'customer') {
            return view('backEnd.pages.customer_data.refund', $data);
        } else {
            return view(theme('pages.profile.refunds.refund'), $data);
        }
    }

    public function config_index()
    {
        return view('refund::admin.refund_config.index');
    }

    public function make_refund_request($id)
    {
        $orderRepo = new OrderRepository;
        $refundReasonRepo = new RefundReasonRepository;
        $shippingService = new ShippingRepository;
        $data['shipping_methods'] = $shippingService->getActiveAll();
        $data['order'] = $orderRepo->orderFindByID(decrypt($id));
        $data['reasons'] = $refundReasonRepo->getAll();
        return view(theme('pages.profile.refunds.create'), $data);
    }

    public function reasons_list()
    {
        return view('refund::admin.refund_reasons.index');
    }

    public function store(Request $request)
    {

        if (empty($request->product_ids)) {

            Toastr::error(__('common.select_product_first'));
            return back();
        }
        DB::beginTransaction();
        try {

            $this->refundService->store($request->except("_token"), auth()->user());
            DB::commit();
            Toastr::success(__('common.created_successfully'), __('common.success'));
            LogActivity::successLog('refund store successful.');
            return redirect()->route('refund.frontend.index');
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }


    public function show($id)
    {
        $data['refund_request'] = $this->refundService->findByID($id);
        return view('refund::admin.refund_requests.details', $data);
    }


    public function seller_show($id)
    {
        $data['refund_detail'] = $this->refundService->findDetailByID($id);
        $refundProcessRepo = new RefundProcessRepository;
        $data['processes'] = $refundProcessRepo->getAll();
        return view('refund::seller.refund_requests.details', $data);
    }

    public function my_refund_show($id)
    {
        $data['refund_request'] = $this->refundService->findByID(decrypt($id));
        $refundProcessRepo = new RefundProcessRepository;
        $data['processes'] = $refundProcessRepo->getAll();
        return view(theme('pages.profile.refunds.details'), $data);
    }



    public function update_refund_request_by_admin(Request $request, $id)
    {
        try {
            $this->refundService->updateRefundRequestByAdmin($request->except("_token"), $id);
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('Update refund request by admin successful.');
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

    public function update_refund_state_by_seller(Request $request, $id)
    {
        try {
            $this->refundService->updateRefundStateBySeller($request->except("_token"), $id);
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('Update refund state by seller successful.');
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }


    public function config_update(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        try {
            $general_settings = new GeneralSettingRepository;
            $general_settings->updateActivationStatus($request->only('id', 'status'));
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('Config update successful.');
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }

    public function getRefundPackage(Request $request){
        $refund_detail = $this->refundService->findDetailByID($request->id);
        $refundProcessRepo = new RefundProcessRepository;
        $processes = $refundProcessRepo->getAll();
        return view('refund::admin.refund_requests.components._modal_for_package_manage',compact('refund_detail','processes'));
    }
}
