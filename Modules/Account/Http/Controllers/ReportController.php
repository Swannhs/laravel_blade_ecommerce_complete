<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Account\Repositories\ChartOfAccountRepository;
use Modules\Account\Services\ReportService;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    /**
     * @var ReportService
     */
    private $reportService;
    /**
     * @var Request
     */
    private $request;


    public function __construct(ReportService $reportService, Request $request)
    {
        $this->reportService = $reportService;
        $this->request = $request;
        $this->middleware('maintenance_mode');
    }

    public function profit()
    {
        $data = $this->reportService->profit($this->request->all());

        if ($this->request->ajax()) {
            return view('account::report.profit.data', compact('data'));
        }
        return view('account::report.profit.index', compact('data'));
    }

    public function transaction()
    {
        $data = $this->reportService->transaction($this->request->all());
        if ($this->request->ajax()) {
            return view('account::report.transaction.data')->with($data);
        }

        return view('account::report.transaction.index');
    }

    public function transaction_dtbl(Request $request)
    {
        return DataTables::of($this->reportService->transactionQuery($request->all())['transactions'])
                ->addIndexColumn()
                ->addColumn('date',function($transactions){
                    return dateFormat($transactions->transaction_date);
                })
                ->addColumn('chart_of_account',function($transactions){
                    return $transactions->account ? $transactions->account->name : '';
                })
                ->addColumn('bank_account', function($transactions){
                    return $transactions->bank ? $transactions->bank->bank_name : '';
                })
                ->addColumn('title', function($transactions){
                    return $transactions->title;
                })
                ->addColumn('credit', function($transactions){
                    return ($transactions->type == 'in') ? amountFormat($transactions->amount) : '';
                })
                ->addColumn('debit', function($transactions){
                    return ($transactions->type == 'out') ? amountFormat($transactions->amount) : '';
                })
                ->make(true);
    }

    public function statement()
    {
        $data = $this->reportService->statement($this->request->all());
        return view('account::report.statement.index')->with($data);
    }

    public function statement_dtbl(Request $request)
    {
        return DataTables::of($this->reportService->statementQuery($request->all())['transactions'])
                ->addIndexColumn()
                ->addColumn('date',function($transactions){
                    return dateFormat($transactions->transaction_date);
                })
                ->addColumn('title', function($transactions){
                    return $transactions->title;
                })
                ->addColumn('credit', function($transactions){
                    return ($transactions->type == 'in') ? amountFormat($transactions->amount) : '';
                })
                ->addColumn('debit', function($transactions){
                    return ($transactions->type == 'out') ? amountFormat($transactions->amount) : '';
                })
                ->make(true);
    }

    public function bankStatement($id)
    {
        $data = $this->reportService->bankReport($id);

        return view('account::report.bank.index')->with($data);
    }
}
