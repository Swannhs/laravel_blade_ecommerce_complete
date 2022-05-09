<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FrontendCMS\Entities\Feature;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Feature::create(['title'=>'Great Value','slug'=>'Great Value','icon'=>'ti-cup']);
        Feature::create(['title'=>'Secured Shopping','slug'=>'Secured Shopping','icon'=>'ti-shield']);
        Feature::create(['title'=>'Worldwide Delivery','slug'=>'Worldwide Delivery','icon'=>'ti-truck']);
        Feature::create(['title'=>'24/7 Support','slug'=>'24/7 Support','icon'=>'ti-headphone-alt']);
        Feature::create(['title'=>'Easy Payment','slug'=>'Easy Payment','icon'=>'ti-server']);
        Feature::create(['title'=>'Portable Shopping','slug'=>'Portable Shopping','icon'=>'ti-shopping-cart-full']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('features');
    }
}
