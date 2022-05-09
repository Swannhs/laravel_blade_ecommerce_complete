<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger("customer_id")->nullable();
            $table->unsignedBigInteger("seller_id")->nullable();
            $table->foreign("customer_id")->on("users")->references("id");
            $table->foreign("seller_id")->on("users")->references("id");
            $table->foreign("order_id")->on("orders")->references("id");
            $table->string('title');
            $table->text('url')->nullable();
            $table->text('description')->nullable();
            $table->boolean('read_status')->default(0);
            $table->boolean('super_admin_read_status')->default(0);
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
        Schema::dropIfExists('customer_notifications');
    }
}
