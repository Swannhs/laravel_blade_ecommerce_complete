<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Modules\Setup\Entities\Country;

class CreateCountriesTable extends Migration
{
    
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('phonecode', 255)->nullable();
            $table->string('flag', 255)->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        $sql_path = base_path('static_sql/countries.sql');
        DB::unprepared(file_get_contents($sql_path));
        
    }

    
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
