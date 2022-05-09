<?php

namespace Modules\Product\Export;
use Modules\Product\Entities\UnitType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class UnitExport implements FromCollection, WithHeadings
{
    use Exportable;
    public function collection()
    {
        return DB::table('unit_types')->select('id', 'name')->get();
    }
    public function headings(): array
    {
        return [
            'id',
            'name',
        ];
    }
}
