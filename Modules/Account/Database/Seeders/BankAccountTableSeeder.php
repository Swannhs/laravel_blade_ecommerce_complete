<?php

namespace Modules\Account\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Account\Entities\BankAccount;

class BankAccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        BankAccount::truncate();

        BankAccount::create([
           'bank_name' => 'DBBL',
           'branch_name' => 'Mirpur',
           'account_name' => 'John Smith',
           'account_number' => '1325464652',
        ]);
    }
}
