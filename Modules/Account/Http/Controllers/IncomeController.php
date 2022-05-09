<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Account\DataTable\IncomeDataTable;
use Modules\Account\Http\Requests\IncomeRequest;
use Modules\Account\Services\TransactionService;
use Modules\UserActivityLog\Traits\LogActivity;

class IncomeController extends Controller
{
    /**
     * @var IncomeService
     */
    private $transactionService;
    /**
     * @var Request
     */
    private $request;

    /**
     * IncomeController constructor.
     * @param IncomeService $transactionService
     */
    public function __construct(
        TransactionService $transactionService,
        Request $request
    ) {
        $this->transactionService = $transactionService;
        $this->request = $request;
        $this->middleware('maintenance_mode');
        $this->middleware('prohibited_demo_mode')->only('store', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(IncomeDataTable $dataTable)
    {
        return $dataTable->render('account::income.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        try {
            $preRequisite = $this->transactionService->preRequisite(['income']);
            return view('account::income.create', $preRequisite);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
        }
    }

    public function store(IncomeRequest $request)
    {
        $this->transactionService->store(array_merge($request->validated(), ['come_from' => 'income', 'type' => 'in']));

        LogActivity::successLog('income created successful.');
        return $this->success(['message' => trans('income.The requested income created successful')]);
    }

    public function show($id)
    {
        if ($this->request->ajax() and $this->request->wantsJson()) {
            return $this->transactionService->find($id);
        }
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $preRequisite = $this->transactionService->preRequisite(['income'], $id);
        return view('account::income.edit', $preRequisite);
    }

    public function update(IncomeRequest $request, $id)
    {
        $this->transactionService->update($request->validated(), $id);
        LogActivity::successLog('income updated successful.');
        return $this->success(['message' => trans('income.The requested income updated successful')]);
    }

    public function destroy($id)
    {
        $this->transactionService->destroy($id);
        LogActivity::successLog('income deleted successful.');
        return $this->success(['message' => trans('income.The requested income deleted successful')]);
    }
}
