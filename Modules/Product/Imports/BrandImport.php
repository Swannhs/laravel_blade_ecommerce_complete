<?php

namespace Modules\Product\Imports;
use Modules\Product\Entities\Brand;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BrandImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Brand([
            'name'    => $row['name'],
            'slug'    => $row['slug'],
            'meta_title'    => $row['meta_title'],
            'meta_description'    => $row['meta_description'],
        ]);
    }
}
