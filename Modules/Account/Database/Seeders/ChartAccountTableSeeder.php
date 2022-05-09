<?php

namespace Modules\Account\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Account\Entities\ChartOfAccount;

class ChartAccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChartOfAccount::truncate();

        ChartOfAccount::create([
            'code' => 89635,
            'type' => 'Income',
            'default_for' => 'Income',
            'name' => 'Income Account',
        ]);


        ChartOfAccount::create([
            'code' => 69636,
            'type' => 'Expense',
            'default_for' => 'Expense',
            'name' => 'Expense Account',
        ]);

        ChartOfAccount::create([
            'code' => 59656,
            'type' => 'Asset',
            'default_for' => 'Asset',
            'name' => 'Asset Account',
        ]);

        ChartOfAccount::create([
            'code' => 59856,
            'type' => 'Loan',
            'default_for' => 'Loan',
            'name' => 'Loan Account',
        ]);
    }
}
