<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FrontendCMS\Entities\AboutUs;

class CreateAboutUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('mainTitle');
            $table->string('slug')->unique();
            $table->string('subTitle');
            $table->longText('mainDescription');
            $table->string('sec1_image');
            $table->string('sec2_image');
            $table->string('benifitTitle');
            $table->longText('benifitDescription');
            $table->string('sellingTitle');
            $table->longText('sellingDescription');
            $table->string('price');
            $table->timestamps();
        });



        AboutUs::create(['mainTitle' => 'About Us', 'subTitle' => 'Delevering happiness on the goal.',
        'slug' => 'initail slug','mainDescription' => '<p>We believe time is valuable to our fellow residents, and that they should not have to waste hours in traffic, brave bad weather and wait in line just to buy basic necessities like eggs! This is why Chaldal delivers everything you need right at your door-step and at no additional cost.</p>','sec1_image' => 'frontend\default\img\about_1.png','sec2_image' => 'frontend\default\img\about_1.png',
        'benifitTitle' => 'Benefits', 'benifitDescription' => '<p>Opens the doorway for everybody to shop over the Internet. We constantly update with lot of new products, services and special offers. We provide on-time delivery of products and quick resolution of any concerns.</p>',
        'sellingTitle' => 'ALL YOU JUST NEED IS START SELLING', 'sellingDescription' => '<p>Selling is very easy in this site. You can easily register here as a vendor and start selling immediately</p>', 'price' => 'Starting @ $7.00/month']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('about_us');
    }
}
