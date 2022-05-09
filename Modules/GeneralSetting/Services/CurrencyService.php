<?php
namespace Modules\GeneralSetting\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\GeneralSetting\Repositories\CurrencyRepository;
use Illuminate\Support\Arr;

class CurrencyService
{
    protected $currencyRepository;

    public function __construct(CurrencyRepository  $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function getAll()
    {
        return $this->currencyRepository->getAll();
    }

    public function create($data)
    {
        return $this->currencyRepository->create($data);
    }

    public function update($data, $id)
    {
        return $this->currencyRepository->update($data, $id);
    }

    public function findById($id)
    {
        return $this->currencyRepository->find($id);
    }

    public function delete($id)
    {
        return $this->currencyRepository->delete($id);
    }
}
