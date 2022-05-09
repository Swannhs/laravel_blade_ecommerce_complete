<?php

namespace Modules\FrontendCMS\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use \Modules\FrontendCMS\Services\ReturnExchangeService;
use Exception;
use Modules\FrontendCMS\Http\Requests\UpdateReturnExchangeRequest;
use Modules\UserActivityLog\Traits\LogActivity;

class ReturnExchangeController extends Controller
{
    protected $returnService;

    public function __construct(ReturnExchangeService $returnService)
    {
        $this->middleware('maintenance_mode');
        $this->returnService = $returnService;
    }
    public function index()
    {

        try {
            $return = $this->returnService->getAll();
            return view('frontendcms::return_exchange.index', compact('return'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return 'error';
        }
    }



    public function update(UpdateReturnExchangeRequest $request)
    {
        try {

            $update = $this->returnService->update($request->only('mainTitle', 'returnTitle', 'slug', 'exchangeTitle', 'returnDescription', 'exchangeDescription'), $request->id);
            LogActivity::successLog('return exchange update successful.');
            return $update;
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }
}
