<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreateCitiesTable extends Migration
{
    
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('state_id');
            $table->boolean('status')->default(1);
            $table->timestamps();

        });

        $file_directory = base_path('static_sql/cities');

        $total_files = count(\File::files($file_directory));

        for($i=1;$i<=$total_files;$i++){
            $sql_path = base_path('static_sql/cities/cities_'.$i.'.sql');
            DB::unprepared(file_get_contents($sql_path));
        }
    }

    
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
