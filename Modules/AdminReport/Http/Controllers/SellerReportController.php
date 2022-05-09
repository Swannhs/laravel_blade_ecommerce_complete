<?php

namespace Modules\AdminReport\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AdminReport\Services\SellerReportService;
use Yajra\DataTables\Facades\DataTables;

class SellerReportController extends Controller
{
    protected $sellerReportService;


    public function __construct(SellerReportService $sellerReportService)
    {
        $this->sellerReportService = $sellerReportService;
        $this->middleware('maintenance_mode');
    }



    public function product(Request $request)
    {
        return view('adminreport::seller.product.index');
    }



    public function order(Request $request)
    {

        $type = $request->type;
        $start_date = NULL;
        $end_date = NULL;

        if ($request->has('start_date')) {
            $start_date = date('Y-m-d', strtotime($request->start_date));
            $end_date = date('Y-m-d', strtotime($request->end_date));
        }

        return view('adminreport::seller.order.index', compact('type', 'start_date', 'end_date'));
    }



    public function order_data(Request $request)
    {
        if (isset($_GET['table'])) {
            $start_date = date('Y-m-d', strtotime($request->start_date));
            $end_date = date('Y-m-d', strtotime($request->end_date. '+1 day'));
            $table = $_GET['table'];

            if ($table == 'pending') {
                $order = $this->sellerReportService->order()->where('is_confirmed', 0)->whereBetween('created_at', [$start_date, $end_date]);
            } elseif ($table == 'confirmed') {
                $order = $this->sellerReportService->order()->where('is_confirmed', 1)->whereBetween('created_at', [$start_date, $end_date]);
            } elseif ($table == 'completed') {
                $order = $this->sellerReportService->order()->where('is_completed', 1)->whereBetween('created_at', [$start_date, $end_date]);
            } elseif ($table == 'inhouse') {
                $order = $this->sellerReportService->order()->where('order_type', 'inhouse_order')->whereBetween('created_at', [$start_date, $end_date]);
            } elseif ($table == 'all') {
                $order = $this->sellerReportService->order()->whereBetween('created_at', [$start_date, $end_date]);
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
                    return $order->packages->sum('number_of_product');
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
                ->addColumn('action', function ($order) {
                    return '';
                })
                ->rawColumns(['order_status', 'is_paid', 'action'])
                ->make(true);
        } else {
            return [];
        }
    }



    public function top_customer()
    {
        return view('adminreport::seller.top_customer.index');
    }



    public function top_customer_data()
    {

        $data = $this->sellerReportService->topCustomer();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function ($data) {
                return $data->user->first_name . " " . $data->user->last_name;
            })
            ->addColumn('email', function ($data) {
                return $data->user->email;
            })
            ->addColumn('phone', function ($data) {
                return $data->user->phone;
            })
            ->addColumn('total', function ($data) {
                return round($data->total, 2);
            })
            ->addColumn('joined_at', function ($data) {
                return date(app('general_setting')->dateFormat->format, strtotime($data->user->created_at));
            })
            ->toJson();
    }



    public function top_selling_item()
    {
        return view('adminreport::seller.top_selling_item.index');
    }



    public function top_selling_item_data()
    {
        $data = $this->sellerReportService->topSellingItem();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('seller', function ($data) {
                return $data->seller->first_name . " " . $data->seller->last_name;
            })
            ->addColumn('product', function ($data) {
                return $data->product_name;
            })
            ->addColumn('total_sale', function ($data) {
                return $data->total_sale;
            })
            ->addColumn('avg_rating', function ($data) {
                return $data->avg_rating;
            })
            ->toJson();
    }




    public function review()
    {
        return view('adminreport::seller.review.index');
    }



    public function review_data()
    {
        $data = $this->sellerReportService->review();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('seller', function ($data) {
                return $data->seller->first_name . " " . $data->seller->last_name;
            })
            ->addColumn('number_of_review', function ($data) {
                return $data->number_of_review;
            })
            ->addColumn('rating', function ($data) {
                return round($data->rating, 2);
            })
            ->toJson();
    }
}
