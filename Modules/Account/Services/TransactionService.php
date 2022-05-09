<?php


namespace Modules\Account\Services;


use Modules\Account\Repositories\BankAccountRepository;
use Modules\Account\Repositories\ChartOfAccountRepository;
use Modules\Account\Repositories\TransactionRepository;

class TransactionService
{
    /**
     * @var TransactionRepository
     */
    protected $transactionRepository;

    /**
     * @var TransactionRepository
     */
    protected $chartOfAccountRepository;
    /**
     * @var BankAccountRepository
     */
    private $bankAccountRepository;

    /**
     * TransactionService constructor.
     * @param TransactionRepository $transactionRepository
     */
    public function __construct(
        TransactionRepository $transactionRepository,
        ChartOfAccountRepository $chartOfAccountRepository,
        BankAccountRepository $bankAccountRepository
    )
    {
        $this->transactionRepository = $transactionRepository;
        $this->chartOfAccountRepository = $chartOfAccountRepository;
        $this->bankAccountRepository = $bankAccountRepository;
    }

    /**
     * @throws \Throwable
     */
    public function preRequisite($type = 'income', $id = null)
    {
        $chart_of_accounts = $this->chartOfAccountRepository->pluckByType($type);
        $bankAccounts = $this->bankAccountRepository->pluckAll();
        $payment_methods = generate_normal_translated_select_option(get_account_var('list')['payment_method']);
        if (!$id) {
            $default_account = $this->chartOfAccountRepository->findDefaultAccount($type);
            $default_id = $default_account ? $default_account->id : Null;
            return compact('chart_of_accounts', 'default_id', 'bankAccounts', 'payment_methods');
        } else {
            $transaction = $this->transactionRepository->find($id);
            $default_id = $transaction->chart_of_account_id;
            return compact('chart_of_accounts', 'default_id', 'transaction', 'bankAccounts', 'payment_methods');
        }
    }

    public function store($request)
    {
        return $this->transactionRepository->create($request);
    }

    public function update($request, $id)
    {
        return $this->transactionRepository->update($request, $id);
    }

    /**
     * @throws \Throwable
     */
    public function find($id, $with = [])
    {
        return $this->transactionRepository->find($id, $with);
    }

    public function destroy($id)
    {
        return $this->transactionRepository->delete($id);
    }

}
