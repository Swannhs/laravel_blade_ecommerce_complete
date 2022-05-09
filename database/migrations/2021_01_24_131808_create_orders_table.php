<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{

    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('order_payment_id')->nullable();
            $table->string('order_type')->nullable();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('payment_type');
            $table->unsignedInteger('is_paid')->default(0);
            $table->unsignedInteger('is_confirmed')->default(0);
            $table->unsignedInteger('is_completed')->default(0);
            $table->unsignedInteger('is_cancelled')->default(0);
            $table->unsignedInteger('cancel_reason_id')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->unsignedBigInteger('customer_shipping_address')->nullable();
            $table->unsignedBigInteger('customer_billing_address')->nullable();
            $table->unsignedInteger('number_of_package')->nullable();
            $table->double('grand_total')->nullable();
            $table->double('sub_total')->nullable();
            $table->double('discount_total')->nullable();
            $table->double('shipping_total')->nullable();
            $table->unsignedInteger('number_of_item')->nullable();
            $table->unsignedInteger('order_status')->nullable();
            $table->double('tax_amount')->default(0)->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
