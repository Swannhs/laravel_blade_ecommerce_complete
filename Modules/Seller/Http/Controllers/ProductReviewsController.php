<?php

namespace Modules\Seller\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Seller\Services\ProductReviewService;
use Yajra\DataTables\Facades\DataTables;

class ProductReviewsController extends Controller
{
    protected $productReviewService;
    public function __construct(ProductReviewService $productReviewService)
    {
        $this->middleware('maintenance_mode');
        $this->productReviewService = $productReviewService;
    }

    public function index()
    {
        $reviews = $this->productReviewService->getAll();
        return view('seller::product_reviews.index',compact('reviews'));
    }

    public function getData(){
        $review = $this->productReviewService->getAll();
        return DataTables::of($review)
        ->addIndexColumn()
        ->addColumn('rating', function($review){
            return view('seller::product_reviews.components._rating_td',compact('review'));
        })
        ->addColumn('customer_feedback', function($review){
            return view('seller::product_reviews.components._customer_feedback_td',compact('review'));
        })
        ->addColumn('customer_time', function($review){
            return view('seller::product_reviews.components._customer_time_td',compact('review'));
        })
        ->addColumn('reply', function($review){
            return view('seller::product_reviews.components._reply_td',compact('review'));
        })
        ->rawColumns(['rating','customer_feedback','customer_time','reply'])
        ->toJson();
    }

    public function reply(Request $review)
    {
        $review = $this->productReviewService->getById($review->id);
        return view('seller::product_reviews.components.reply',compact('review'));
    }


    public function replyStore(Request $request)
    {
        $request->validate([
            'review' => 'required'
        ]);
        $this->productReviewService->reviewStore($request->except('_token'));

        \LogActivity::successLog('reply store successful.');
        return $this->reloadWithData();
    }
    private function reloadWithData(){

        $reviews = $this->productReviewService->getAll();
        return response()->json([
            'TableData' =>  (string)view('seller::product_reviews.components.list', compact('reviews'))
        ]);
    }

}
