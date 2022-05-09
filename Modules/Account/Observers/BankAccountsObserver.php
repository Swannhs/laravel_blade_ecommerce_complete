<?php


namespace Modules\Account\Observers;


use Illuminate\Support\Facades\Auth;
use Modules\Account\Entities\BankAccount;
use Modules\Account\Repositories\TransactionRepository;

class BankAccountsObserver
{
    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    /**
     * BankAccountsObserver constructor.
     * @param TransactionRepository $transactionRepository
     */
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function creating(BankAccount $bankAccount){
        $bankAccount->created_by = Auth::id();
    }

    public function created(BankAccount $bankAccount){
        if ($bankAccount->opening_balance){
            $this->transactionRepository->create($this->transactionFormate($bankAccount));
        }
    }

    public function updating(BankAccount $bankAccount){
        $bankAccount->updated_by = Auth::id();
    }

    public function updated(BankAccount $bankAccount){
        $transaction = $this->transactionRepository->findByParam(['bank_account_id' => $bankAccount->id,'come_from' => 'opening_balance']);
        if ($transaction){
            if ($bankAccount->opening_balance){
                $this->transactionRepository->update($this->transactionFormate($bankAccount), $transaction->id);
            } else{
                $transaction->delete();
            }
        } else {
            if ($bankAccount->opening_balance){
                $this->transactionRepository->create($this->transactionFormate($bankAccount));
            }
        }
    }

    private function transactionFormate(BankAccount $bankAccount)
    {
        return [
            'title' => "Opening balance",
            'description' => "{$bankAccount->bank_name} ({$bankAccount->account_number})",
            'payment_method' => 'Bank',
            'amount' => $bankAccount->opening_balance,
            'transaction_date' => date('Y-m-d'),
            'bank_account_id' => $bankAccount->id,
            'come_from' => 'opening_balance',
            'type' => 'in',
        ];
    }


}
