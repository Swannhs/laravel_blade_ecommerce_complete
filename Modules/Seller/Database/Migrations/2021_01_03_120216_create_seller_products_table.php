<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSellerProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->double('tax')->default(0);
            $table->string('tax_type')->nullable();
            $table->double('discount')->default(0);
            $table->string('discount_type')->nullable();
            $table->date('discount_start_date')->nullable();
            $table->date('discount_end_date')->nullable();
            $table->string('product_name', 255)->nullable();
            $table->string("slug", 255)->nullable();
            $table->string('thum_img', 255)->nullable();
            $table->boolean('status')->default(1);
            $table->tinyInteger('stock_manage')->default(0);
            $table->boolean('is_approved')->default(0);
            $table->double('min_sell_price', 28,2)->default(0);
            $table->double('max_sell_price', 28,2)->default(0);
            $table->unsignedBigInteger('total_sale')->default(0);
            $table->double('avg_rating', 8,2)->default(0);
            $table->timestamp('recent_view')->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('seller_products');
    }
}
