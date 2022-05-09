<?php

namespace Modules\AdminReport\Http\Controllers;

use App\Models\OrderPackageDetail;
use Illuminate\Contracts\Support\Renderable;
use Modules\AdminReport\Services\SaleReportService;
use Modules\MultiVendor\Services\MerchantService;
use \Modules\MultiVendor\Repositories\MerchantRepository;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;

class SaleReportController extends Controller
{
    protected $saleReportService;

    public function __construct(SaleReportService $saleReportService)
    {
        $this->saleReportService = $saleReportService;
        $this->middleware('maintenance_mode');
    }


    public function seller_wise_index(Request $request)
    {

        $merchantService = new MerchantService(new MerchantRepository());
        $data['sellers'] = $merchantService->getAllSeller();
        if ($request->has('seller_id')) {
            $data['seller_id'] = $request->seller_id;
            $data['sale_type'] = $request->sale_type;
        }
        return view('adminreport::sales_report.seller_wise_index', $data);
    }


    public function get_seller_wise_sale_report_data($seller_id, $sale_type)
    {
        $data = $this->saleReportService->getSaleReportByUser($seller_id, $sale_type);
        return DataTables::of($data)
            ->addColumn('order_number', function ($data) use ($sale_type) {
                return $data->$sale_type->order_number;
            })
            ->addColumn('customer_name', function ($data) use ($sale_type) {

                if ($data->$sale_type->customer) {
                    return $data->$sale_type->customer->first_name . " " . $data->$sale_type->customer->last_name;
                }
            })
            ->addColumn('customer_email', function ($data) use ($sale_type) {

                return $data->$sale_type->customer_email;
            })
            ->addColumn('total_amount', function ($data) use ($sale_type) {

                return $data->$sale_type->grand_total;
            })
            ->addColumn('date', function ($data) use ($sale_type) {

                return date(app('general_setting')->dateFormat->format, strtotime($data->$sale_type->created_at));
            })
            ->toJson();
    }
}
