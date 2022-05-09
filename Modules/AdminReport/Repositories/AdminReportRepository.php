<?php

namespace Modules\AdminReport\Repositories;

use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\Wishlist;
use Illuminate\Support\Facades\DB;
use Modules\PaymentGateway\Entities\PaymentMethod;
use Modules\Product\Entities\Product;
use Modules\Review\Entities\ProductReview;
use Modules\Review\Entities\SellerReview;
use Modules\MultiVendor\Entities\SellerAccount;
use Modules\Seller\Entities\SellerProduct;
use Modules\Visitor\Entities\VisitorHistory;
use Modules\Wallet\Entities\WalletBalance;

class AdminReportRepository
{


    public function getVisitor()
    {
        return VisitorHistory::all();
    }


    public function wishlist()
    {
        return Wishlist::latest()->with('user', 'seller', 'product');
    }


    public function walletHistories()
    {
        return WalletBalance::where('status', 1)->with('user');
    }


    public function topSeller()
    {
        return SellerAccount::orderBy('total_sale_qty', 'desc')->with('user');
    }


    public function topCustomer()
    {
        return OrderPayment::whereNotNull('user_id')->select(DB::raw('user_id as user_id'), DB::raw('sum(amount) as total'))
            ->groupBy(DB::raw('user_id'))
            ->with('user')
            ->orderBy('total', 'desc');
    }



    public function topSellingItem()
    {
        return SellerProduct::where('status', 1)->with('product', 'seller')->orderBy('total_sale', 'desc');
    }



    public function productReview()
    {
        return ProductReview::where('status', 1)
            ->select('product_id', DB::raw('avg(rating) as rating'), DB::raw('count(*) as number_of_review'))
            ->groupBy('product_id')
            ->with('product');
    }


    public function sellerReview()
    {
        return SellerReview::where('status', 1)
            ->select('seller_id', DB::raw('avg(rating) as rating'), DB::raw('count(*) as number_of_review'))
            ->groupBy('seller_id')
            ->with('seller');
    }




    public function products()
    {
        return Product::with('brand','seller')->where('is_approved', 1)->latest();
    }


    public function sellerProducts($seller_id)
    {

        $sellerProduct = SellerProduct::where('user_id',$seller_id)->pluck('id');
        return Product::whereIn('id',$sellerProduct)->with('brand',  'seller')->latest();
    }



    public function wishlistByUser()
    {
        return Wishlist::select('user_id', DB::raw('count(*) as total'))
            ->groupBy('user_id')
            ->with('user');
    }


    public function wishlistByProduct()
    {
        return Wishlist::select('seller_product_id', DB::raw('count(*) as total'))
            ->groupBy('seller_product_id')
            ->with('product');
    }



    public function paymentMethod()
    {
        return PaymentMethod::all();
    }


    public function payment()
    {
        return OrderPayment::with('user', 'method');
    }


    public function paymentByMethod($payment_method_id)
    {
        return OrderPayment::where('payment_method', $payment_method_id)->with('user', 'method');
    }


    public function order()
    {
        return Order::with('packages', 'customer')->latest();
    }
}
