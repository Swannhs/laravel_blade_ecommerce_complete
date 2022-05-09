<?php


namespace Modules\Account\Observers;


use Illuminate\Support\Facades\Auth;
use Modules\Account\Entities\ChartOfAccount;
use Modules\Account\Repositories\TransactionRepository;

class ChartOfAccountsObserver
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

    public function creating(ChartOfAccount $chartOfAccount)
    {
        $level = 0;
        $parent = ChartOfAccount::find($chartOfAccount->parent_id);
        if ($parent) {
            $chartOfAccount->type = $parent->type;
            $level = $parent->level + 1;
        }


        if (!$chartOfAccount->code) {
            $id = ChartOfAccount::max('id') + 1;
            $chartOfAccount->code = $chartOfAccount->type . '-' . $this->generate_code($id, $parent);
        }

        if ($chartOfAccount->default_for) {
            ChartOfAccount::where('default_for', $chartOfAccount->default_for)->update(['default_for' => null]);
        }

        $chartOfAccount->created_by = Auth::id();
        $chartOfAccount->level = $level;
    }

    protected function generate_code($id, $parent)
    {
        if ($parent) {
            $id = $parent->id . '-' . $id;
            if ($parent->parent) {
                return $this->generate_code($id, $parent->parent);
            }
        }
        return $id;

    }

    public function created(ChartOfAccount $chartOfAccount)
    {

        if ($chartOfAccount->opening_balance) {
            $this->transactionRepository->create($this->transactionFormate($chartOfAccount));
        }

    }

    public function updating(ChartOfAccount $chartOfAccount)
    {

        $parent = ChartOfAccount::find($chartOfAccount->parent_id);

        if (!$chartOfAccount->code) {
            $id = ChartOfAccount::max('id') + 1;
            $chartOfAccount->code = $chartOfAccount->type . '-' . $this->generate_code($id, $parent);
        }

        if ($chartOfAccount->default_for) {
            ChartOfAccount::where('default_for', $chartOfAccount->default_for)->update(['default_for' => null]);
        }

        $chartOfAccount->updated_by = Auth::id();
    }

    public function updated(ChartOfAccount $chartOfAccount)
    {
        $transaction = $this->transactionRepository->findByParam(['chart_of_account_id' => $chartOfAccount->id]);
        if ($transaction) {
            if ($chartOfAccount->opening_balance) {
                $this->transactionRepository->update($this->transactionFormate($chartOfAccount), $transaction->id);
            } else {
                $transaction->delete();
            }
        } else {
            if ($chartOfAccount->opening_balance) {
                $this->transactionRepository->create($this->transactionFormate($chartOfAccount));
            }
        }
    }

    private function transactionFormate(ChartOfAccount $chartOfAccount)
    {
        $type = 'in';
        if ($chartOfAccount->type == 'expense') {
            $type = 'out';
        }

        return [
            'title' => "Opening balance",
            'description' => "{$chartOfAccount->name} ({$chartOfAccount->code})",
            'payment_method' => 'cash',
            'amount' => $chartOfAccount->opening_balance,
            'transaction_date' => date('Y-m-d'),
            'chart_of_account_id' => $chartOfAccount->id,
            'come_from' => 'opening_balance',
            'type' => $type,
        ];
    }
}
