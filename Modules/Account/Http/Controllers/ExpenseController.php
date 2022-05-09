<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Account\DataTable\ExpenseDataTable;
use Modules\Account\Http\Requests\ExpenseRequest;
use Modules\Account\Services\TransactionService;
use Modules\UserActivityLog\Traits\LogActivity;

class ExpenseController extends Controller
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
    public function index(ExpenseDataTable $dataTable)
    {
        return $dataTable->render('account::expense.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $preRequisite = $this->transactionService->preRequisite(['expense']);
        return view('account::expense.create', $preRequisite);
    }

    public function store(ExpenseRequest $request)
    {
        $come_from = 'expense';
        if ($request->gst_pay) {
            $come_from = 'gst_tsx';
        }
        if ($request->product_tax_pay) {
            $come_from = 'product_tax';
        }
        $this->transactionService->store(array_merge($request->validated(), ['come_from' => $come_from, 'type' => 'out']));

        LogActivity::successLog('expenses created successful.');
        return $this->success(['message' => trans('expense.The requested expense created successful')]);
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
        $preRequisite = $this->transactionService->preRequisite(['expense'], $id);
        return view('account::expense.edit', $preRequisite);
    }

    public function update(ExpenseRequest $request, $id)
    {
        $this->transactionService->update($request->validated(), $id);
        LogActivity::successLog('expenses updated successful.');
        return $this->success(['message' => trans('expense.The requested expense updated successful')]);
    }

    public function destroy($id)
    {
        $this->transactionService->destroy($id);
        LogActivity::successLog('expenses deleted successful.');
        return $this->success(['message' => trans('expense.The requested expense deleted successful')]);
    }
}
