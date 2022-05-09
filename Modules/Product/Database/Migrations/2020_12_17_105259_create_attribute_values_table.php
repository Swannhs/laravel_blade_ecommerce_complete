<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Product\Entities\AttributeValue;

class CreateAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();
            $table->string("value", 50);
            $table->unsignedBigInteger("attribute_id")->nullable();
            $table->foreign("attribute_id")->on("attributes")->references("id")->onDelete("cascade");
            $table->timestamps();
        });

        AttributeValue::create([
            'attribute_id' => 1,
            'value' => 'black'
        ]);
        AttributeValue::create([
            'attribute_id' => 1,
            'value' => 'red'
        ]);
        AttributeValue::create([
            'attribute_id' => 1,
            'value' => 'white'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_values');
    }
}
