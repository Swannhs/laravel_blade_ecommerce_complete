<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FrontendCMS\Entities\SubscribeContent;

class CreateSubscribeContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribe_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('second')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });



        SubscribeContent::create(['title' => 'GET A QUICK QUOTE', 'subtitle' => 'Get to Know Project Estimate?', 'description' => 'Subscribe our newsletter for coupon, offer and exciting promotional discount.']);

        SubscribeContent::create(['title' => 'Subscribe to Our Newsletter', 'subtitle' => 'Subscribe our newsletter for coupon, offer and exciting promotional discount.','image' => 'frontend/default/img/popup.png', 'second' => 5]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribe_contents');
    }
}
