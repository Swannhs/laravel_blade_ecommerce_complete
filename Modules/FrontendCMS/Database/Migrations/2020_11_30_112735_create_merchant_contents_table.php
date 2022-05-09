<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FrontendCMS\Entities\MerchantContent;

class CreateMerchantContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('pricing_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('mainTitle')->nullable();
            $table->string('subTitle')->nullable();
            $table->text('Maindescription')->nullable();
            $table->string('pricing')->nullable();
            $table->string('benifitTitle')->nullable();
            $table->text('benifitDescription')->nullable();
            $table->string('howitworkTitle')->nullable();
            $table->text('howitworkDescription')->nullable();
            $table->string('pricingTitle')->nullable();
            $table->text('pricingDescription')->nullable();
            $table->string('sellerRegistrationTitle')->nullable();
            $table->text('sellerRegistrationDescription')->nullable();
            $table->string('queryTitle')->nullable();
            $table->text('queryDescription')->nullable();
            $table->string('faqTitle')->nullable();
            $table->text('faqDescription')->nullable();
            $table->timestamps();
        });




        MerchantContent::create([
            'mainTitle' => 'Become A Merchant', 'subTitle' => 'ALL YOU JUST NEED IS START SELLING',
            'slug' => 'ALL YOU JUST NEED IS START SELLING', 'Maindescription' => '<p>Formal educational training is not required to become this type of merchant. However, having a degree in a related field, such as business or communications.</p>',
            'pricing' => 'Starting @ $7.00/month', 'benifitTitle' => 'Benefits',
            'benifitDescription' => '<p>One of the most important benefits a merchant account can bring is the ability to accept credit and debit cards. Credit cards and debit cards continue grow in preference among customers, gaining ground as the new norm.</p>', 'howitworkTitle' => 'How it works',
            'howitworkDescription' => '<p>Feed your mind with fascinating facts about the world around us.', 'pricingTitle' => 'Merchant Pricing',
            'pricingDescription' => '<p>Pricing is the process whereby a business sets the price at which it will sell its products and services, and may be part of the business marketing plan</p>', 'queryTitle' => 'Send us your query', 'queryDescription' => '<p>A query is a question or a request for information expressed in a formal manner.</p>',
            'faqTitle' => 'Frequently Asked Questions', 'faqDescription' => '<p>A list of questions and answers relating to a particular subject, especially one giving basic information for users of a website.</p>', 'sellerRegistrationTitle' => 'Register', 'sellerRegistrationDescription' => '<p>A seller registration form is a registration form used by businesses or organizations who sell items or services at a location.</p>'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchant_contents');
    }
}
