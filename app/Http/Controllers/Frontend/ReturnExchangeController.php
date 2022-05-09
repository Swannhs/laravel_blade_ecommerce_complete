<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Modules\FrontendCMS\Entities\ReturnExchange;

class ReturnExchangeController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }

    public function index(){
        try{
            $data = ReturnExchange::first();
            return view(theme('pages.return_exchange'), compact('data'));
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}
