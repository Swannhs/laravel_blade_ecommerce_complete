<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GiftCardTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_card_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("gift_card_id");
            $table->unsignedBigInteger("tag_id");
            $table->foreign("gift_card_id")->on("gift_cards")->references("id")->onDelete("cascade");
            $table->foreign("tag_id")->on("tags")->references("id")->onDelete("cascade");
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
        Schema::dropIfExists('gift_card_tag');
    }
}
