<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FrontendCMS\Entities\WorkingProcess;

class CreateWorkingProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_processes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title');
            $table->string('image');
            $table->text('description');
            $table->boolean('status')->default(1);
            $table->boolean('position')->default(1);
            $table->timestamps();
        });

        WorkingProcess::create(['title'=>'Register as admin','description'=>'You can register as admin and get many benifits.','image'=>'frontend\default\img\icon\icon_5.png']);
        WorkingProcess::create(['title'=>'Upload your items','description'=>'Easily upload your item to the website.','image'=>'frontend\default\img\icon\icon_6.png']);
        WorkingProcess::create(['title'=>'Start selling to fullfill orders','description'=>'You can start selling immediately. You get more order and sell more product','image'=>'frontend\default\img\icon\icon_7.png']);
        WorkingProcess::create(['title'=>'Get Paid Instanly','description'=>'Get the payment instantly without any harasment.','image'=>'frontend\default\img\icon\icon_8.png']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('working_processes');
    }
}
