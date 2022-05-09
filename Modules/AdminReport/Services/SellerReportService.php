<?php
namespace Modules\AdminReport\Services;

use Illuminate\Support\Facades\Validator;
use Modules\AdminReport\Repositories\SellerReportRepository;
use Illuminate\Support\Arr;

class SellerReportService
{
    protected $sellerReportRepo;



    public function __construct(SellerReportRepository $sellerReportRepo)
    {
        $this->sellerReportRepo = $sellerReportRepo;
    }


    public function topCustomer()
    {
        return $this->sellerReportRepo->topCustomer();
    }


    public function topSellingItem()
    {
        return $this->sellerReportRepo->topSellingItem();
    }


    public function review()
    {
        return $this->sellerReportRepo->review();
    }


    public function products()
    {
        return $this->sellerReportRepo->products();
    }


    public function order()
    {
        return $this->sellerReportRepo->order();
    }



}
