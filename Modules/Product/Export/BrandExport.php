<?php

namespace Modules\Product\Export;
use Modules\Product\Entities\Brand;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class BrandExport implements FromCollection, WithHeadings
{
    use Exportable;
    public function collection()
    {
        return DB::table('brands')->select('id', 'name')->get();
    }
    public function headings(): array
    {
        return [
            'id',
            'name',
        ];
    }
}
