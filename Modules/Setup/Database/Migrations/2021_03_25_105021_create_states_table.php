<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateStatesTable extends Migration
{
    
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('country_id');
            $table->boolean('status')->default(1);
            $table->timestamps();

            
        });

        $sql_path = base_path('static_sql/states.sql');
        DB::unprepared(file_get_contents($sql_path));
    }

    
    public function down()
    {
        Schema::dropIfExists('states');
    }
}
