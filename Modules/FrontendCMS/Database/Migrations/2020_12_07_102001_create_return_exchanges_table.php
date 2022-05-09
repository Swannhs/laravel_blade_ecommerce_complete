<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FrontendCMS\Entities\ReturnExchange;

class CreateReturnExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_exchanges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('mainTitle');
            $table->string('slug');
            $table->string('returnTitle');
            $table->string('exchangeTitle');
            $table->longText('returnDescription');
            $table->longText('exchangeDescription');
            $table->timestamps();
        });


        ReturnExchange::create(['mainTitle' => 'Return & Exchange Policy', 'slug' => 'slug', 'returnTitle' => 'Returns Policy',
         'exchangeTitle' => 'Exchange Policy',
         'returnDescription' => 'We strive to make our customers satisfied with the product they have purchased from us. If you are having trouble with a premium JoomShaper product or believe it is defective, and/or you’re feeling frustrated, then please submit a ticket to our Helpdesk to report your defective product and our team will assist you as soon as possible. For a damaged extension or template, we will request from you a link and/or a screenshot of the issue to be sent to our support service.
         Please also note that:
<li>You may cancel your account at any time, however, there are no refunds for cancellation.</li>
<li>If you get a refund you cannot use the downloaded premium products any more.</li>
<li>If the product (after update) is still damaged, we may offset the amount of your refund by the diminished value of the product.</li>
<li>Refunds can take up to 14 days to reflect in your account.</li>
         ',

         'exchangeDescription' => 'We strive to make our customers satisfied with the product they have purchased from us. If you are having trouble with a premium JoomShaper product or believe it is defective, and/or you’re feeling frustrated, then please submit a ticket to our Helpdesk to report your defective product and our team will assist you as soon as possible. For a damaged extension or template, we will request from you a link and/or a screenshot of the issue to be sent to our support service.

         Please also note that:
         <li>You may cancel your account at any time, however, there are no refunds for cancellation.</li>
         <li>If you get a refund you cannot use the downloaded premium products any more.</li>
         <li>If the product (after update) is still damaged, we may offset the amount of your refund by the diminished value of the product.</li>
         <li>Refunds can take up to 14 days to reflect in your account.</li>
         ']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('return_exchanges');
    }
}
