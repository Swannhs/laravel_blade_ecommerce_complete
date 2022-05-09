<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FrontendCMS\Entities\ContactContent;

class CreateContactContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('mainTitle');
            $table->string('subTitle');
            $table->string('slug');
            $table->string('email');
            $table->longText('description');
            $table->timestamps();
        });






        ContactContent::create(['mainTitle' => 'Contact Us', 'subTitle' => 'SEND US ANY QUERY THAT YOU ARE HAVING TROUBLE WITH','slug' => 'initail slug','email' => 'info@amazcart.com','description' => '<p>We are an industry-leading company that values honesty, integrity, and efficiency. Building quality products and caring for the users are what made us stand out since the beginning.</p>']);
    }




    public function down()
    {
        Schema::dropIfExists('contact_contents');
    }
}
