<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Account\DataTable\ChartOfAccountDataTable;
use Modules\Account\Http\Requests\ChartOfAccountRequest;
use Modules\Account\Services\ChartOfAccountService;
use Modules\UserActivityLog\Traits\LogActivity;

class ChartOfAccountController extends Controller
{
    /**
     * @var ChartOfAccountService
     */
    private $chartOfAccountService;
    /**
     * @var Request
     */
    private $request;

    /**
     * ChartOfAccountController constructor.
     * @param ChartOfAccountService $chartOfAccountService
     */
    public function __construct(
        ChartOfAccountService $chartOfAccountService,
        Request $request
    ) {
        $this->chartOfAccountService = $chartOfAccountService;
        $this->request = $request;
        $this->middleware('maintenance_mode');
        $this->middleware('prohibited_demo_mode')->only('store', 'update', 'destroy');
    }

    public function index(ChartOfAccountDataTable $dataTable)
    {
        return $dataTable->render('account::chart_of_account.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $preRequisite = $this->chartOfAccountService->preRequisite();
        return view('account::chart_of_account.create', $preRequisite);
    }

    public function store(ChartOfAccountRequest $request)
    {
        $this->chartOfAccountService->store($request->validated());
        LogActivity::successLog('chart of account created successful.');
        return $this->success(['message' => trans('chart_of_account.The requested chart of account created successful')]);
    }

    public function show($id)
    {
        if ($this->request->ajax() and $this->request->wantsJson()) {
            return $this->chartOfAccountService->find($id);
        }
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $preRequisite = $this->chartOfAccountService->preRequisite($id);

        return view('account::chart_of_account.edit', $preRequisite);
    }

    public function update(ChartOfAccountRequest $request, $id)
    {
        $this->chartOfAccountService->update($request->validated(), $id);
        LogActivity::successLog('chart of account updated successful.');
        return $this->success(['message' => trans('chart_of_account.The requested chart of account updated successful')]);
    }

    public function destroy($id)
    {
        $this->chartOfAccountService->destroy($id);

        LogActivity::successLog('chart of account deleted successful.');
        return $this->success(['message' => trans('chart_of_account.The requested chart of account deleted successful')]);
    }
}
