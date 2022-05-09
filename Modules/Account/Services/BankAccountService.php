<?php


namespace Modules\Account\Services;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Account\Repositories\BankAccountRepository;
use Throwable;

class BankAccountService
{
    /**
     * @var BankAccountRepository
     */
    protected $bankAccountRepository;

    /**
     * ChartOfAccountService constructor.
     * @param BankAccountRepository $bankAccountRepository
     */
    public function __construct(BankAccountRepository $bankAccountRepository)
    {
        $this->chartOfAccountRepository = $bankAccountRepository;
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
