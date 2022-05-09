<?php

namespace Modules\Setup\Repositories;

use Modules\Setup\Entities\IntroPrefix;
use Auth;

class IntroPrefixRepository
{
    public function getAll()
    {
        return IntroPrefix::latest()->get();
    }

    public function create(array $data)
    {
        return IntroPrefix::create($data);
    }

    public function find($id)
    {
        return IntroPrefix::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        return IntroPrefix::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return IntroPrefix::findOrFail($id)->delete();
    }
}
