<?php

namespace Modules\Product\Export;
use Modules\Product\Entities\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class CategoryExport implements FromCollection, WithHeadings
{
    use Exportable;
    public function collection()
    {
        return DB::table('categories')->select('id', 'name', 'parent_id', 'total_sale')->get();
    }
    public function headings(): array
    {
        return [
            'id',
            'name',
            'parent_id',
            'total_sale',
        ];
    }
}
