<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPackageDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_package_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('seller_id');
            $table->string('package_code')->nullable();
            $table->unsignedInteger('number_of_product');
            $table->double('shipping_cost')->nullable();
            $table->string('shipping_date')->nullable();
            $table->unsignedBigInteger('shipping_method')->nullable();
            $table->unsignedInteger('is_cancelled')->default(0);
            $table->unsignedInteger('cancel_reason_id')->nullable();
            $table->unsignedInteger('is_reviewed')->default(0);
            $table->unsignedBigInteger('delivery_status')->default(1);
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->boolean('gst_claimed')->default(0);
            $table->double('tax_amount')->default(0)->nullable();
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
        Schema::dropIfExists('order_package_details');
    }
}
