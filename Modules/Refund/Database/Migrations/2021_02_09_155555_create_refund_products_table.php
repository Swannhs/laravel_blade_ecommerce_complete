<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('refund_request_detail_id')->unsigned();
            $table->unsignedBigInteger('seller_product_sku_id')->unsigned();
            $table->unsignedBigInteger('refund_reason_id')->unsigned();
            $table->Integer('return_qty')->nullable();
            $table->double('return_amount', 28,2)->default(0);
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
        Schema::dropIfExists('refund_products');
    }
}
