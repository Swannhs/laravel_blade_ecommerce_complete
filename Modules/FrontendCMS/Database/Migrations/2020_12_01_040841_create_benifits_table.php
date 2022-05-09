<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FrontendCMS\Entities\Benifit;

class CreateBenifitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benifits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title');
            $table->string('image');
            $table->text('description');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Benifit::create(['title'=>'Instant Selling Start','description'=>'Use these effective strategies to learn how to sell your products.','image'=>'frontend\default\img\icon\icon_1.png']);
        Benifit::create(['title'=>'Managing
        Dashboard Panel','description'=>'You can manage your dashboard panels easily.','image'=>'frontend\default\img\icon\icon_2.png']);
        Benifit::create(['title'=>'Secured
        Payment Options','description'=>'We have secured and easy to pay payment option.','image'=>'frontend\default\img\icon\icon_3.png']);
        Benifit::create(['title'=>'Awesome
        Privilege Options','description'=>'You can get many privilege as a vendor or customer.','image'=>'frontend\default\img\icon\icon_4.png']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('benifits');
    }
}
