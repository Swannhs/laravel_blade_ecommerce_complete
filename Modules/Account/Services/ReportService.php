<?php


namespace Modules\Account\Services;


use Carbon\Carbon;
use Modules\Account\Repositories\BankAccountRepository;
use Modules\Account\Repositories\ChartOfAccountRepository;
use Modules\Account\Repositories\TransactionRepository;

class ReportService
{

    protected $chartOfAccountRepository,$transactionRepository,$bankAccountRepository;

    public function __construct(
        ChartOfAccountRepository $chartOfAccountRepository,
        TransactionRepository $transactionRepository,
        BankAccountRepository $bankAccountRepository
    )
    {
        $this->chartOfAccountRepository = $chartOfAccountRepository;
        $this->transactionRepository = $transactionRepository;
        $this->bankAccountRepository = $bankAccountRepository;
    }

    public function profit(array $request): array
    {
        $data = [];
        $data['start'] = gv($request, 'start');
        $data['end'] = gv($request, 'end');

        $data['income'] = $this->transactionRepository->getTotalAmountByParamFilterByDate(['type' => 'in','come_from' => ['subscription_payment','sales_income','income','wallet_recharge','payroll_expense','installment_income','loan_expense']], $data['start'], $data['end']);
        $data['expense'] = $this->transactionRepository->getTotalAmountByParamFilterByDate(['type' => 'out','come_from' => ['sales_income','income','expense','wallet_recharge','payroll_expense','installment_income','loan_expense']], $data['start'], $data['end']);

        $data['gst_income'] = $this->transactionRepository->getTotalAmountByParamFilterByDate(['type' => 'in','come_from' => ['gst_tsx']], $data['start'], $data['end']);
        $data['gst_expense'] = $this->transactionRepository->getTotalAmountByParamFilterByDate(['type' => 'out','come_from' => ['gst_tsx']], $data['start'], $data['end']);

        $data['product_tax_income'] = $this->transactionRepository->getTotalAmountByParamFilterByDate(['type' => 'in','come_from' => ['product_tax']], $data['start'], $data['end']);
        $data['product_tax_expense'] = $this->transactionRepository->getTotalAmountByParamFilterByDate(['type' => 'out','come_from' => ['product_tax']], $data['start'], $data['end']);

        return $data;
    }

    public function transaction(array $request): array
    {
        $data = [];
        $data['start'] = gv($request, 'start');
        $data['end'] = gv($request, 'end');

        $data['transactions'] = $this->transactionRepository->allTransactions($data['start'], $data['end']);

        return $data;
    }

    public function transactionQuery(array $request): array
    {
        $filter_date = filterDateFormatingForSearchQuery($request['filter_date']);
        $data = [];
        $data['start'] = $filter_date[0];
        $data['end'] = $filter_date[1];

        $data['transactions'] = $this->transactionRepository->allTransactionsQuery($data['start'], $data['end']);

        return $data;
    }

    public function statement(array $request): array
    {
        $data = [];

        $data['start'] = gv($request, 'start');
        $data['end'] = gv($request, 'end');

        $data['account_id'] = gv($request, 'account_id');
        $data['bank_account_id'] = gv($request, 'bank_account_id');

        $data['transactions'] = $this->transactionRepository->allTransactions($data['start'], $data['end'], $data['account_id'], $data['bank_account_id']);
        $data['accounts'] = $this->chartOfAccountRepository->pluckAll();
        $data['banks'] = $this->bankAccountRepository->pluckAll();

        return $data;
    }

    public function statementQuery(array $request): array
    {
        $filter_date = filterDateFormatingForSearchQuery($request['filter_date']);
        $data = [];
        $data['start'] = $filter_date[0];
        $data['end'] = $filter_date[1];

        $data['account_id'] = gv($request, 'account_id');
        $data['bank_account_id'] = gv($request, 'bank_account_id');

        $data['transactions'] = $this->transactionRepository->allTransactions($data['start'], $data['end'], $data['account_id'], $data['bank_account_id']);


        return $data;
    }

    public function bankReport($id): array
    {
        $data['bank'] = $this->bankAccountRepository->find($id);
        $data['transactions'] = $data['bank']->transactions;

        return $data;
    }
}
