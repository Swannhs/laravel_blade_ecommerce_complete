<?php

namespace Modules\Seller\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Seller\Services\SellerReviewService;
use Yajra\DataTables\Facades\DataTables;

class SellerReviewsController extends Controller
{
    protected $sellerReviewService;
    public function __construct(SellerReviewService $sellerReviewService)
    {
        $this->middleware('maintenance_mode');
        $this->sellerReviewService = $sellerReviewService;
    }
    
    public function index()
    {
        return view('seller::seller_review.index');

    }

    public function getData(){
        $review = $this->sellerReviewService->getAll();
        return DataTables::of($review)
        ->addIndexColumn()
        ->addColumn('rating', function($review){
            return view('review::seller_review.components._rating_td',compact('review'));
        })
        ->addColumn('customer_feedback', function($review){
            return view('review::seller_review.components._customer_feedback_td',compact('review'));
        })
        ->addColumn('customer_time', function($review){
            return view('review::seller_review.components._customer_time_td',compact('review'));
        })
        ->rawColumns(['rating','customer_feedback','customer_time'])
        ->toJson();
    }

}
