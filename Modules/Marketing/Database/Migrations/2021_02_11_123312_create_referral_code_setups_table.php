<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Marketing\Entities\ReferralCodeSetup;

class CreateReferralCodeSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_code_setups', function (Blueprint $table) {
            $table->id();
            $table->double('maximum_limit');
            $table->double('amount');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        ReferralCodeSetup::create([
            'maximum_limit' => 10,
            'amount' => 10,
            'status' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referral_code_setups');
    }
}
