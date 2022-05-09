<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function ok($items = null)
    {
    return response()->json($items)->setEncodingOptions(JSON_NUMERIC_CHECK);
    }


    public function success($items = null, $status = 200)
    {
    $data = ['status' => 'success'];

    if ($items instanceof Arrayable) {
    $items = $items->toArray();
    }

    if ($items) {
    foreach ($items as $key => $item) {
    $data[$key] = $item;
    }
    }
    return response()->json($data, $status)->setEncodingOptions(JSON_NUMERIC_CHECK);
    }

    public function error($items = null, $status = 500)
    {
    $data = array();

    if ($items) {
    foreach ($items as $key => $item) {
    $data['errors'][$key][] = $item;
    }
    }

    return response()->json($data, $status)->setEncodingOptions(JSON_NUMERIC_CHECK);
    }
}
