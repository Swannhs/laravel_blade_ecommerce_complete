<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Appearance\Entities\HeaderNewUserZonePanel;

class CreateHeaderNewUserZonePanelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('header_new_user_zone_panels', function (Blueprint $table) {
            $table->id();
            $table->string('navigation_label')->nullable();
            $table->string('title')->nullable();
            $table->string('pricing')->nullable();
            $table->unsignedBigInteger('new_user_zone_id')->nullable();
            $table->timestamps();
        });
        HeaderNewUserZonePanel::create([
            'navigation_label' => 'New User Zone',
            'title' => 'Get your coupon',
            'pricing' => 'usd 5',
            'new_user_zone_id' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('header_new_user_zone_panels');
    }
}
