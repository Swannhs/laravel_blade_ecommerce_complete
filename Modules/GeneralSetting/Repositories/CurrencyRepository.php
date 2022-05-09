<?php

namespace Modules\GeneralSetting\Repositories;
use Modules\GeneralSetting\Entities\Currency;

class CurrencyRepository
{
    public function getAll()
    {
        return Currency::orderByDesc('status')->get();
    }

    public function getActiveAll(){
        return Currency::where('status', 1)->get();
    }
    
    public function create(array $data)
    {
        $currency = new Currency();
        $currency->fill($data)->save();
    }

    public function find($id)
    {
        return Currency::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        // dd($data);
        return Currency::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return Currency::findOrFail($id)->delete();
    }
}
