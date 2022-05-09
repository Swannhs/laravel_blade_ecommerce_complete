<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('form_data')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        $forms = [
            ['name'=>'Affiliate User Registration','status'=>1],
            ['name'=>'Customer Registration','status'=>1],
            ['name'=>'Seller Registration','status'=>1],
            ['name'=>'Contact','status'=>1],
        ];

        try{
            DB::table('custom_forms')->insert($forms);
        }catch(Exception $e){

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_forms');
    }
}
