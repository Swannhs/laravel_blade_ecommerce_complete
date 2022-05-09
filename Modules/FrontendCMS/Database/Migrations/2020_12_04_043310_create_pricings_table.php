<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FrontendCMS\Entities\Pricing;

class CreatePricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->double('monthly_cost')->default(0);
            $table->double('yearly_cost')->default(0);
            $table->unsignedInteger('team_size')->nullable();
            $table->float('stock_limit')->nullable();
            $table->float('transaction_fee');
            $table->string('best_for')->nullable();
            $table->boolean('is_monthly')->default(1);
            $table->boolean('is_yearly')->default(0);
            $table->boolean('status')->default(1);
            $table->boolean('is_featured')->default(0);
            $table->timestamps();
        });

        Pricing::create(['name'=>'Individual','monthly_cost'=>50,'yearly_cost'=>850,'team_size'=>1,'transaction_fee'=>3]);
        Pricing::create(['name'=>'Business','monthly_cost'=>150,'yearly_cost'=>7850,'team_size'=>25,'transaction_fee'=>5]);
        Pricing::create(['name'=>'Company','monthly_cost'=>550,'yearly_cost'=>9850,'team_size'=>100,'transaction_fee'=>7]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pricings');
    }
}
