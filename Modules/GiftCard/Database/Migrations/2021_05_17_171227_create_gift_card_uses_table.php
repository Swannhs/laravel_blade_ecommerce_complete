<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftCardUsesTable extends Migration
{

    public function up()
    {
        Schema::create('gift_card_uses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gift_card_id');
            $table->unsignedBigInteger('qty');
            $table->unsignedBigInteger('order_id');
            $table->boolean('is_used')->default(0);
            $table->string('secret_code')->nullable();
            $table->date('mail_sent_date')->nullable();
            $table->boolean('is_mail_sent')->default(0);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('gift_card_uses');
    }
}
