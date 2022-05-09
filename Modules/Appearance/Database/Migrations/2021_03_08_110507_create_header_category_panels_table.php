<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeaderCategoryPanelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('header_category_panels', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->boolean('status')->default(1);
            $table->boolean('is_newtab');
            $table->unsignedBigInteger('position')->default(986754);
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('header_category_panels');
    }
}
