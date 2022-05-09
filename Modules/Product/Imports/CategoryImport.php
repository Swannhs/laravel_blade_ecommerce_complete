<?php

namespace Modules\Product\Imports;
use Modules\Product\Entities\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Category([
            'id'     => $row['id'],
            'name'    => $row['name'],
            'slug'    => $row['slug'],
            'parent_id'    => $row['parent_id'],
            'commission_rate'    => $row['commission_rate'],
        ]);
    }
}
