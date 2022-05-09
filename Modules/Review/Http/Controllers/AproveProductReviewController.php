<?php

namespace Modules\Review\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Review\Services\ProductReviewService;
use Modules\UserActivityLog\Traits\LogActivity;
use Yajra\DataTables\Facades\DataTables;

class AproveProductReviewController extends Controller
{
    protected $productReviewService;
    public function __construct(ProductReviewService $productReviewService)
    {
        $this->middleware('maintenance_mode');
        $this->productReviewService = $productReviewService;
    }

    public function index()
    {
        return view('review::product_review.index');
    }

    public function allGetData(){

        $review = $this->productReviewService->getAll();
        return DataTables::of($review)
        ->addIndexColumn()
        ->addColumn('rating', function($review){
            return view('review::product_review.components._pending_rating_td',compact('review'));
        })
        ->addColumn('customer_feedback', function($review){
            return view('review::product_review.components._pending_customer_feedback_td',compact('review'));
        })
        ->addColumn('status', function($review){
            return view('review::product_review.components._all_status_td',compact('review'));
        })
        ->addColumn('customer_time', function($review){
            return view('review::product_review.components._pending_customer_time_td',compact('review'));
        })
        ->addColumn('approve', function($review){
            return view('review::product_review.components._all_approve_td',compact('review'));
        })
        ->rawColumns(['rating','customer_feedback','customer_time','approve'])
        ->toJson();
    }

    public function pendingGetData(){
        $review = $this->productReviewService->getPendingAll();
        return DataTables::of($review)
        ->addIndexColumn()
        ->addColumn('rating', function($review){
            return view('review::product_review.components._pending_rating_td',compact('review'));
        })
        ->addColumn('customer_feedback', function($review){
            return view('review::product_review.components._pending_customer_feedback_td',compact('review'));
        })
        ->addColumn('customer_time', function($review){
            return view('review::product_review.components._pending_customer_time_td',compact('review'));
        })
        ->addColumn('approve', function($review){
            return view('review::product_review.components._pending_approve_td',compact('review'));
        })
        ->rawColumns(['rating','customer_feedback','customer_time','approve'])
        ->toJson();
    }

    public function DeclinedGetData(){

        $review = $this->productReviewService->getDeclinedAll();
        return DataTables::of($review)
        ->addIndexColumn()
        ->addColumn('rating', function($review){
            return view('review::product_review.components._pending_rating_td',compact('review'));
        })
        ->addColumn('customer_feedback', function($review){
            return view('review::product_review.components._pending_customer_feedback_td',compact('review'));
        })
        ->addColumn('customer_time', function($review){
            return view('review::product_review.components._pending_customer_time_td',compact('review'));
        })
        ->addColumn('approve', function($review){
            return view('review::product_review.components._declined_approve_td',compact('review'));
        })
        ->rawColumns(['rating','customer_feedback','customer_time','approve'])
        ->toJson();
    }


    public function approve(Request $request){
        $this->productReviewService->approve($request->id);

        \LogActivity::successLog('review approve successful.');

        return $this->reloadWithData();
    }
    public function approveAll(Request $request){
        $this->productReviewService->approveAll();

        \LogActivity::successLog('review all approve successful.');
        return $this->reloadWithData();
    }
    public function destroy(Request $request){

        $this->productReviewService->deleteById($request->except('_token'));

        \LogActivity::successLog('review delete successful.');
        return $this->reloadWithData();
    }

    private function reloadWithData(){
        return response()->json([
            'allTableData' =>  (string)view('review::product_review.components.all_list'),
            'pendingTableData' =>  (string)view('review::product_review.components.pending_list'),
            'declinedTableData' =>  (string)view('review::product_review.components.declined_list')
        ]);
    }


    public function review_configuration()
    {
        try {
            $reviewConfiguration = $this->productReviewService->getReviewConfiguration();
            return view('review::review_configuration', compact('reviewConfiguration'));
        } catch (\Exception $e) {
            Toastr::error(__('common.operation_failed'));
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }

    public function review_configuration_update(Request $request)
    {
        try {
            $this->productReviewService->reviewConfigurationUpdate($request);
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('seller configuration updated.');
            return back();
        } catch (\Exception $e) {
            Toastr::error(__('common.operation_failed'));
            LogActivity::errorLog($e->getMessage());
            return back();
        }

    }

}
