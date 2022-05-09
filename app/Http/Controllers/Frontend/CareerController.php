<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Modules\UserActivityLog\Traits\LogActivity;

class CareerController extends Controller
{

    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }

    public function index(){
        try{

            return view(theme('pages.career'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }
}
