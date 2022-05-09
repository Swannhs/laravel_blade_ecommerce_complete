<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('method');
            $table->string('type')->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->tinyInteger('module_status')->default(0);
            $table->text('logo')->nullable();
            $table->integer('created_by')->nullable()->default(1)->unsigned();
            $table->integer('updated_by')->nullable()->default(1)->unsigned();
            $table->timestamps();
        });


        DB::table('payment_methods')->insert([
            [
                'id' => 1,
                'method' => 'Cash On Delivery',
                'type' => 'System',
                'active_status' => 1,
                'module_status' => 1,
                'logo' => 'payment_gateway/cod.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 2,
                'method' => 'Wallet',
                'type' => 'System',
                'active_status' => 0,
                'module_status' => 1,
                'logo' => 'payment_gateway/cod.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 3,
                'method' => 'PayPal',
                'type' => 'System',
                'active_status' => 0,
                'module_status' => 1,
                'logo' => 'payment_gateway/paypal.png',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 4,
                'method' => 'Stripe',
                'type' => 'System',
                'active_status' => 0,
                'module_status' => 1,
                'logo' => 'payment_gateway/stripe.png',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 5,
                'method' => 'PayStack',
                'type' => 'System',
                'active_status' => 0,
                'module_status' => 1,
                'logo' => 'payment_gateway/paystack.png',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 6,
                'method' => 'RazorPay',
                'type' => 'System',
                'active_status' => 0,
                'module_status' => 1,
                'logo' => 'payment_gateway/razorpay.png',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 7,
                'method' => 'Bank Payment',
                'type' => 'System',
                'active_status' => 0,
                'module_status' => 1,
                'logo' => 'payment_gateway/bank_payment.png',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 8,
                'method' => 'Instamojo',
                'type' => 'System',
                'active_status' => 0,
                'module_status' => 1,
                'logo' => 'payment_gateway/intamojo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 9,
                'method' => 'PayTM',
                'type' => 'System',
                'active_status' => 0,
                'module_status' => 1,
                'logo' => 'payment_gateway/paytm.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 10,
                'method' => 'Midtrans',
                'type' => 'System',
                'active_status' => 0,
                'module_status' => 1,
                'logo' => 'payment_gateway/midtrans.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 11,
                'method' => 'PayUMoney',
                'type' => 'System',
                'active_status' => 0,
                'module_status' => 1,
                'logo' => 'payment_gateway/payumoney-logo.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 12,
                'method' => 'JazzCash',
                'type' => 'System',
                'active_status' => 0,
                'module_status' => 1,
                'logo' => 'payment_gateway/JazzCash.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 13,
                'method' => 'Google Pay',
                'type' => 'System',
                'active_status' => 0,
                'module_status' => 1,
                'logo' => 'payment_gateway/GooglePay.png',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 14,
                'method' => 'FlutterWave',
                'type' => 'System',
                'active_status' => 0,
                'module_status' => 1,
                'logo' => 'payment_gateway/flutterWavePayment.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
}
