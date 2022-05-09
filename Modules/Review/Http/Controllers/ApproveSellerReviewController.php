<?php

namespace Modules\Review\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Review\Services\SellerReviewService;
use Modules\UserActivityLog\Traits\LogActivity;
use Yajra\DataTables\Facades\DataTables;

class ApproveSellerReviewController extends Controller
{
    protected $sellerReviewService;
    public function __construct(SellerReviewService $sellerReviewService)
    {
        $this->middleware('maintenance_mode');
        $this->sellerReviewService = $sellerReviewService;
    }

    public function index()
    {
        return view('review::seller_review.index');
    }

    public function getallData(){
        $review = $this->sellerReviewService->getAll();
        return DataTables::of($review)
        ->addIndexColumn()
        ->addColumn('seller', function($review){
            return isModuleActive('MultiVendor')?$review->seller->first_name:app('general_setting')->site_title;
        })
        ->addColumn('rating', function($review){
            return view('review::seller_review.components._rating_td',compact('review'));
        })
        ->addColumn('customer_feedback', function($review){
            return view('review::seller_review.components._customer_feedback_td',compact('review'));
        })
        ->addColumn('status', function($review){
            return view('review::seller_review.components._status_td',compact('review'));
        })
        ->addColumn('customer_time', function($review){
            return view('review::seller_review.components._customer_time_td',compact('review'));
        })
        ->addColumn('approve', function($review){
            return view('review::seller_review.components._all_approve_td',compact('review'));
        })
        ->rawColumns(['rating','customer_feedback','customer_time','approve'])
        ->toJson();
    }

    public function getPendingData(){
        $review = $this->sellerReviewService->getPendingAll();
        return DataTables::of($review)
        ->addIndexColumn()
        ->addColumn('seller', function($review){
            return isModuleActive('MultiVendor')?$review->seller->first_name:app('general_setting')->site_title;
        })
        ->addColumn('rating', function($review){
            return view('review::seller_review.components._rating_td',compact('review'));
        })
        ->addColumn('customer_feedback', function($review){
            return view('review::seller_review.components._customer_feedback_td',compact('review'));
        })
        ->addColumn('customer_time', function($review){
            return view('review::seller_review.components._customer_time_td',compact('review'));
        })
        ->addColumn('approve', function($review){
            return view('review::seller_review.components._pending_approve_td',compact('review'));
        })
        ->rawColumns(['rating','customer_feedback','customer_time','approve'])
        ->toJson();
    }

    public function getDeclinedData(){
        $review = $this->sellerReviewService->getDeclinedAll();
        return DataTables::of($review)
        ->addIndexColumn()
        ->addColumn('seller', function($review){
            return isModuleActive('MultiVendor')?$review->seller->first_name:app('general_setting')->site_title;
        })
        ->addColumn('rating', function($review){
            return view('review::seller_review.components._rating_td',compact('review'));
        })
        ->addColumn('customer_feedback', function($review){
            return view('review::seller_review.components._customer_feedback_td',compact('review'));
        })
        ->addColumn('customer_time', function($review){
            return view('review::seller_review.components._customer_time_td',compact('review'));
        })
        ->addColumn('approve', function($review){
            return view('review::seller_review.components._declined_approve_td',compact('review'));
        })
        ->rawColumns(['rating','customer_feedback','customer_time','approve'])
        ->toJson();
    }

    public function approve(Request $request){
        $this->sellerReviewService->approve($request->id);
        LogActivity::successLog('review approve successful.');
        return $this->reloadWithData();
    }
    public function approveAll(Request $request){
        $this->sellerReviewService->approveAll();

        LogActivity::successLog('review ll approve successful.');
        return $this->reloadWithData();
    }
    public function destroy(Request $request){

        $this->sellerReviewService->deleteById($request->except('_token'));

        LogActivity::successLog('review delete successful.');
        return $this->reloadWithData();
    }

    private function reloadWithData(){
        return response()->json([
            'allTableData' =>  (string)view('review::seller_review.components.all_list'),
            'pendingTableData' =>  (string)view('review::seller_review.components.pending_list'),
            'declinedTableData' =>  (string)view('review::seller_review.components.declined_list')
        ]);
    }
}
