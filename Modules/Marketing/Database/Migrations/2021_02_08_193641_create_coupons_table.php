<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('coupon_code');
            $table->unsignedTinyInteger('coupon_type');
            $table->date('start_date');
            $table->date('end_date');
            $table->double('discount')->nullable();
            $table->unsignedTinyInteger('discount_type')->nullable();
            $table->double('minimum_shopping')->nullable();
            $table->double('maximum_discount')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_expire')->default(0);
            $table->boolean('is_multiple_buy')->default(0);
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
