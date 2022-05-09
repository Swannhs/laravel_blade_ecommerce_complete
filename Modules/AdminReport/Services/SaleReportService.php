<?php
namespace Modules\AdminReport\Services;

use Illuminate\Support\Facades\Validator;
use Modules\AdminReport\Repositories\SaleReportRepository;
use Illuminate\Support\Arr;

class SaleReportService
{
    protected $saleReportRepo;

    public function __construct(saleReportRepository $saleReportRepo)
    {
        $this->saleReportRepo = $saleReportRepo;
    }

    public function getSaleReportByUser($seller_id,$sale_type)
    {
        return $this->saleReportRepo->getSaleReportByUser($seller_id,$sale_type);
    }

}
