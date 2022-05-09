<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Appearance\Entities\Header;

class CreateHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('headers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('column_size');
            $table->boolean('is_enable')->default(1);
            $table->boolean('is_full_row')->default(0);
            $table->timestamps();
        });

        Header::create([
            'name' => 'Slider Section',
            'type' => 'slider',
            'column_size' => '8 column',
            'is_enable' => 1
        ]);
        Header::create([
            'name' => 'Category Section',
            'type' => 'category',
            'column_size' => '4 column',
            'is_enable' => 1
        ]);
        Header::create([
            'name' => 'Product Section',
            'type' => 'product',
            'column_size' => '8 column',
            'is_enable' => 1
        ]);
        Header::create([
            'name' => 'New User Zone Section',
            'type' => 'new_user_zone',
            'column_size' => '4 column',
            'is_enable' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('headers');
    }
}
