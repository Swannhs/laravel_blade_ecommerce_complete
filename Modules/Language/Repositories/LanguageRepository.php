<?php

namespace Modules\Language\Repositories;

use Modules\Language\Entities\Language;


class LanguageRepository
{
    public function getAll()
    {
        return Language::orderBy('status', 'desc')->get();
    }

    public function getActiveAll(){
        return Language::where('status', 1)->get();
    }

    public function create(array $data)
    {
        $language = Language::create([
            'code' => $data['code'],
            'name' => $data['name'],
            'native' => $data['native'],
            'rtl' => $data['rtl_ltl'],
            'status' => $data['status']
        ]);
        return true;
    }

    public function find($id)
    {
        return Language::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $language = Language::findOrFail($id);
        $language->update([
            'code' => $data['code'],
            'name' => $data['name'],
            'native' => $data['native'],
            'rtl' => ($id > 114)? $data['rtl_ltl']:$language->rtl,
            'status' => $data['status']
        ]);
        return true;
    }

    public function delete($id)
    {
        return Language::findOrFail($id)->delete();
    }
}
