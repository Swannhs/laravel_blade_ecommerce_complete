<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\OrderManage\Entities\CancelReason;

class CreateCancelReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancel_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('name',75)->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        CancelReason::create(['name'=>'Personal issue','description'=>'I have some personal issue.']);
        CancelReason::create(['name'=>'High price','description'=>'Product price is very high.']);
        CancelReason::create(['name'=>'Delivery date change','description'=>'I want to cancel my order for changing delivery date.']);
        CancelReason::create(['name'=>'Delivery place change','description'=>'I want to cancel my order for changing delivery place.']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cancel_reasons');
    }
}
