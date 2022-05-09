<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundRequestDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_request_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('refund_request_id')->unsigned();
            $table->unsignedBigInteger('order_package_id')->unsigned();
            $table->unsignedBigInteger('seller_id')->unsigned();
            $table->tinyInteger('processing_state')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refund_request_details');
    }
}
