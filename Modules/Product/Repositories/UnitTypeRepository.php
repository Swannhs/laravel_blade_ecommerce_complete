<?php

namespace Modules\Product\Repositories;

use Modules\Product\Entities\UnitType;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Product\Export\UnitExport;
use Auth;

class UnitTypeRepository
{
    public function getAll()
    {
        return UnitType::latest()->get();
    }

    public function getActiveAll()
    {
        return UnitType::latest()->Active()->get();
    }

    public function create(array $data)
    {
        return UnitType::create($data);
    }

    public function find($id)
    {
        return UnitType::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        return UnitType::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        $unit_type = UnitType::findOrFail($id);
        if (count($unit_type->products) > 0) {
            return "not_possible";
        }
        $unit_type->delete();

        return "possible";
    }

    public function csvDownloadUnit()
    {
        if (file_exists(storage_path("app/unit_list.xlsx"))) {
          unlink(storage_path("app/unit_list.xlsx"));
        }
        return Excel::store(new UnitExport, 'unit_list.xlsx');
    }
}
