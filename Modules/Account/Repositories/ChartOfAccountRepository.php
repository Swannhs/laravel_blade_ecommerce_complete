<?php

namespace Modules\Account\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\Account\Entities\ChartOfAccount;

class ChartOfAccountRepository
{
    /**
     * @var ChartOfAccount
     */
    protected $chartOfAccount;

    /**
     * ChartOfAccountRepository constructor.
     * @param ChartOfAccount $chartOfAccount
     */
    public function __construct(ChartOfAccount $chartOfAccount)
    {
        $this->chartOfAccount = $chartOfAccount;
    }

    public function pluckAll($id = null)
    {
        $query = $this->chartOfAccount->select(DB::raw('CONCAT(name, " (", code, ")") AS full_name'), 'id')->where('status', 1)->get();
        if ($id) {
            $query = $query->except($id);
        }
        return $query->pluck('full_name', 'id')->prepend(__('chart_of_account.Add As A Parent Account'), '');
    }

    public function pluckByType($type)
    {
        return $this->chartOfAccount->select(DB::raw('CONCAT(name, " (", code, ")") AS full_name'), 'id')->where('status', 1)->whereIn('type', $type)->get()
            ->pluck('full_name', 'id')->prepend(__('chart_of_account.Select Account'), '');
    }

    public function create($request)
    {
        return $this->chartOfAccount->forceCreate($this->formatRequest($request));
    }

    public function update($request, $id)
    {
        $chartOfAccount = $this->find($id);
        $chartOfAccount->forceFill($this->formatRequest($request, $chartOfAccount))->save();
        return $chartOfAccount->refresh();
    }

    /**
     * @throws \Throwable
     */
    public function find($id, array $with = [])
    {
        $chartOfAccount = $this->chartOfAccount->with($with)->find($id);
        throw_if(!$chartOfAccount, ValidationException::withMessages(['message' =>  __('chart_of_account.The requested chart of account is not found')]));

        return $chartOfAccount;
    }


    /**
     * @throws \Throwable
     */
    public function findDefaultAccount($type, array $with = [])
    {
        return $this->chartOfAccount->with($with)->where('default_for', $type)->first();
    }

    private function formatRequest($request, $chartOfAccount = null): array
    {
        $formatRequest =  [
            'name' => gv($request, 'name'),
            'code' => gv($request, 'code'),
            'opening_balance' => gv($request, 'opening_balance', 0),
            'description' => gv($request, 'description'),
            'default_for' => gv($request, 'default_for'),
            'status' => gbv($request, 'status'),
        ];

        if (!$chartOfAccount) {
            $formatRequest['parent_id'] = gv($request, 'parent_id');
            $formatRequest['type'] = gv($request, 'type');
        }

        return $formatRequest;
    }

    public function delete($id)
    {
        $chartOfAccount = $this->deleteAble($id);
        return $chartOfAccount->delete();
    }

    private function deleteAble($id)
    {
        $chartOfAccount = $this->find($id, ['childs', 'transactions']);
        throw_if($chartOfAccount->childs()->count(), ValidationException::withMessages(['message' => __("account::chart_of_account.You cann\'t delete an account which has child element")]));
        throw_if($chartOfAccount->transactions()->count(), ValidationException::withMessages(['message' => __('chart_of_account.Account has Transaction')]));

        return $chartOfAccount;
    }
}
