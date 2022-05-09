<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Color;

class CreateColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("attribute_value_id")->nullable();
            $table->string("name", 50);
            $table->timestamps();
        });

        Color::create([
            'attribute_value_id' => 1,
            'name' => 'Black'
        ]);
        Color::create([
            'attribute_value_id' => 2,
            'name' => 'Red'
        ]);
        Color::create([
            'attribute_value_id' => 3,
            'name' => 'White'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colors');
    }
}
