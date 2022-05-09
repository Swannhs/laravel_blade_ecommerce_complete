<?php

namespace Modules\AdminReport\Repositories;

use App\Models\OrderPackageDetail;
use App\Models\SearchTerm;
use Modules\Visitor\Entities\VisitorHistory;

class SaleReportRepository
{
    public function getSaleReportByUser($seller_id, $sale_type)
    {
        $orderPkg = OrderPackageDetail::where('seller_id', $seller_id)->with($sale_type)->get();
        return $orderPkg->whereNotNull($sale_type);
    }
}
