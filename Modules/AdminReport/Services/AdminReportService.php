<?php
namespace Modules\AdminReport\Services;

use Illuminate\Support\Facades\Validator;
use Modules\AdminReport\Repositories\AdminReportRepository;
use Illuminate\Support\Arr;

class AdminReportService
{
    protected $adminReportRepo;



    public function __construct(AdminReportRepository $adminReportRepo)
    {
        $this->adminReportRepo = $adminReportRepo;
    }


    public function wishlist()
    {
        return $this->adminReportRepo->wishlist();
    }


    public function getVisitor()
    {
        return $this->adminReportRepo->getVisitor();
    }



    public function walletHistories()
    {
        return $this->adminReportRepo->walletHistories();
    }



    public function topSeller()
    {
        return $this->adminReportRepo->topSeller();
    }


    public function topCustomer()
    {
        return $this->adminReportRepo->topCustomer();
    }


    public function topSellingItem()
    {
        return $this->adminReportRepo->topSellingItem();
    }


    public function productReview()
    {
        return $this->adminReportRepo->productReview();
    }


    public function sellerReview()
    {
        return $this->adminReportRepo->sellerReview();
    }


    public function payment()
    {
        return $this->adminReportRepo->payment();
    }


    public function paymentByMethod($payment_method_id)
    {
        return $this->adminReportRepo->paymentByMethod($payment_method_id);
    }


    public function products()
    {
        return $this->adminReportRepo->products();
    }


    public function sellerProducts($seller_id)
    {
        return $this->adminReportRepo->sellerProducts($seller_id);
    }


    public function wishlistByProduct()
    {
        return $this->adminReportRepo->wishlistByProduct();
    }


    public function wishlistByUser()
    {
        return $this->adminReportRepo->wishlistByUser();
    }


    public function paymentMethod()
    {
        return $this->adminReportRepo->paymentMethod();
    }


    public function order()
    {
        return $this->adminReportRepo->order();
    }



}
