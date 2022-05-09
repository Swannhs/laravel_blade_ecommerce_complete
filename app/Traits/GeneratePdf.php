<?php

namespace App\Traits;

use PDF;

trait GeneratePdf
{
    function generate_pdf($view, $order) {
    	$pdf = PDF::loadView($view, compact('order'));
    	return $pdf->stream($order->order_number.'.pdf');
    }

}
