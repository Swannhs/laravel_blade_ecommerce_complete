<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewUserZoneProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_user_zone_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('new_user_zone_id');
            $table->unsignedBigInteger('seller_product_id');
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->foreign('new_user_zone_id')->references('id')->on('new_user_zones')->onDelete('cascade');
            $table->foreign('seller_product_id')->references('id')->on('seller_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new_user_zone_products');
    }
}
