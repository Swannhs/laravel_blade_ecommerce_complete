<?php


namespace Modules\Account\Services;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Account\Repositories\ChartOfAccountRepository;
use Throwable;

class ChartOfAccountService
{
    /**
     * @var ChartOfAccountRepository
     */
    protected $chartOfAccountRepository;

    /**
     * ChartOfAccountService constructor.
     * @param ChartOfAccountRepository $chartOfAccountRepository
     */
    public function __construct(ChartOfAccountRepository $chartOfAccountRepository)
    {
        $this->chartOfAccountRepository = $chartOfAccountRepository;
    }

    /**
     * @param null $id
     * @return array
     * @throws Throwable
     */
    public function preRequisite($id = null): array
    {
        $chart_of_accounts = $this->chartOfAccountRepository->pluckAll($id);
        $default_for = array_merge([null => __('chart_of_account.Select Default Account For')], generate_normal_translated_select_option(get_account_var('list')['account_default_for']));

        $account_types = generate_normal_translated_select_option(get_account_var('list')['account_type']);
        if ($id) {
            $chartOfAccount = $this->find($id);
            return compact('chart_of_accounts', 'default_for', 'chartOfAccount', 'account_types');
        }
        return compact('chart_of_accounts', 'default_for', 'account_types');
    }

    /**
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        return $this->chartOfAccountRepository->create($request);
    }

    /**
     * @param $request
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function update($request, $id)
    {
        return $this->chartOfAccountRepository->update($request, $id);
    }

    /**
     * @throws Throwable
     */
    public function find($id, $with = [])
    {
        return $this->chartOfAccountRepository->find($id, $with);
    }

    /**
     * @param $id
     * @return bool|mixed|null
     */
    public function destroy($id)
    {
        return $this->chartOfAccountRepository->delete($id);
    }
}
