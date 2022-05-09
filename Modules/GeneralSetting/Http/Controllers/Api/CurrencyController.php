<?php

namespace Modules\GeneralSetting\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GeneralSetting\Repositories\CurrencyRepository;


class CurrencyController extends Controller
{
    protected $currencyRepo;

    public function __construct(CurrencyRepository $currencyRepo)
    {
        $this->currencyRepo = $currencyRepo;
    }

    // Currency List

    public function index(){
        $currencies = $this->currencyRepo->getActiveAll();

        return response()->json([
            'currencies' => $currencies,
            'msg' => 'success'
        ]);
    }

}
