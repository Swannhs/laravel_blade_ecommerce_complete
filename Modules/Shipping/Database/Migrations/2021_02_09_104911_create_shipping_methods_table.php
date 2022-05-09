<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateShippingMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->string('method_name', 200)->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('shipment_time', 100)->nullable();
            $table->double('cost', 28,2)->default(0);
            $table->boolean('is_active')->default(1);
            $table->unsignedInteger('request_by_user')->nullable();
            $table->boolean('is_approved')->default(1);
            $table->timestamps();
        });
        DB::table('shipping_methods')->insert([
            [
                'id' => 1,
                'method_name' => 'Email Delivery',
                'logo' => null,
                'phone' => null,
                'shipment_time' => '12-24 hrs',
                'cost' => 0,
                'is_active' => 1,
                'request_by_user' => null,
                'is_approved' => 1
            ], [
                'id' => 2,
                'method_name' => 'Flat Rate',
                'logo' => null,
                'phone' => null,
                'shipment_time' => '0-3 days',
                'cost' => 20,
                'is_active' => 1,
                'request_by_user' => null,
                'is_approved' => 1
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
        Schema::dropIfExists('shipping_methods');
    }
}
