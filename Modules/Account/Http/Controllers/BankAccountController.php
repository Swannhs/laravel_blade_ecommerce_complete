<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Account\DataTable\BankAccountDataTable;
use Modules\Account\Http\Requests\BankAccountRequest;
use Modules\Account\Services\BankAccountService;
use Modules\UserActivityLog\Traits\LogActivity;

class BankAccountController extends Controller
{
    /**
     * @var BankAccountService
     */
    private $bankAccountService;
    /**
     * @var Request
     */
    private $request;

    /**
     * BankAccountController constructor.
     * @param BankAccountService $bankAccountService
     */
    public function __construct(


        BankAccountService $bankAccountService,
        Request $request
    )
    {
        $this->bankAccountService = $bankAccountService;
        $this->request = $request;
        $this->middleware('maintenance_mode');
        $this->middleware('prohibited_demo_mode')->only('store','update','destroy');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(BankAccountDataTable $dataTable)
    {
        return $dataTable->render('account::bank_account.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('account::bank_account.create');
    }

    public function store(BankAccountRequest $request)
    {
        $this->bankAccountService->store($request->validated());
        LogActivity::successLog('bank created successful.');
        return $this->success(['message' => trans('bank_account.The requested bank account created successful')]);
    }

    public function show($id)
    {
        if ($this->request->ajax() and $this->request->wantsJson()) {
            return $this->bankAccountService->find($id);
        }
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $bankAccount = $this->bankAccountService->find($id);

        return view('account::bank_account.edit', compact('bankAccount'));
    }

    public function update(BankAccountRequest $request, $id)
    {
        $this->bankAccountService->update($request->validated(), $id);
        LogActivity::successLog('bank updated successful.');
        return $this->success(['message' => trans('bank_account.The requested bank account updated successful')]);
    }

    public function destroy($id)
    {
        $this->bankAccountService->destroy($id);
        LogActivity::successLog('bank deleted successful.');
        return $this->success(['message' => trans('bank_account.The requested bank account deleted successful')]);
    }
}
