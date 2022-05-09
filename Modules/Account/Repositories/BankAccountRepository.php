<?php


namespace Modules\Account\Repositories;


use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\Account\Entities\BankAccount;

class BankAccountRepository
{
    /**
     * @var BankAccount
     */
    protected $bankAccount;

    /**
     * BankAccountRepository constructor.
     * @param BankAccount $bankAccount
     */
    public function __construct(BankAccount $bankAccount)
    {
        $this->bankAccount = $bankAccount;
    }

    public function pluckAll()
    {
        return $this->bankAccount->select(DB::raw('CONCAT(bank_name, " (", account_number, ")") AS full_name'), 'id')->where('status', 1)->get()
            ->pluck('full_name', 'id')->prepend(__('chart_of_account.Select Account'), "");
    }

    public function pluckByType($type)
    {
        return $this->bankAccount->select(DB::raw('CONCAT(name, " (", code, ")") AS full_name'), 'id')->where(['status' => 1, 'type' => $type])->get()
            ->pluck('full_name', 'id')->prepend(__('chart_of_account.Select Account'), "");
    }

    public function create($request)
    {
        return $this->bankAccount->forceCreate($this->formatRequest($request));
    }

    public function update($request, $id)
    {
        $bankAccount = $this->find($id);
        $bankAccount->forceFill($this->formatRequest($request))->save();
        return $bankAccount->refresh();
    }

    /**
     * @throws \Throwable
     */
    public function find($id, array $with = [])
    {
        $bankAccount = $this->bankAccount->with($with)->find($id);
        throw_if(!$bankAccount, ValidationException::withMessages(['message' => __('bank_account.The requested bank account is not found')]));

        return $bankAccount;
    }

    private function formatRequest($request): array
    {
        return [
            'bank_name' => gv($request, 'bank_name'),
            'branch_name' => gv($request, 'branch_name'),
            'account_name' => gv($request, 'account_name'),
            'account_number' => gv($request, 'account_number'),
            'opening_balance' => gv($request, 'opening_balance', 0),
            'description' => gv($request, 'description'),
            'status' => gbv($request, 'status'),
        ];
    }

    public function delete($id)
    {
        $bankAccount = $this->deleteAble($id);
        return $bankAccount->delete();
    }

    private function deleteAble($id)
    {
        $bankAccount = $this->find($id, ['transactions' => function ($q) {
            return $q->where('come_from', '!=', 'opening_balance');
        }]);

        throw_if($bankAccount->transactions->count(), ValidationException::withMessages(['message' => __("account::bank_account.You can\'t delete an account which has child element")]));

        return $bankAccount;
    }
}
