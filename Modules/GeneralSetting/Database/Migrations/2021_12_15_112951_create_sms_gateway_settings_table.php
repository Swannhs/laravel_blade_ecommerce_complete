<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\GeneralSetting\Entities\SmsGatewaySetting;

class CreateSmsGatewaySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_gateway_settings', function (Blueprint $table) {
            $table->id();
            $table->string('url')->nullable();
            $table->string('send_to_parameter_name')->nullable();
            $table->string('message_parameter_name')->nullable();
            $table->string('request_method')->nullable();
            $table->string('parameter_1_key')->nullable();
            $table->string('parameter_2_key')->nullable();
            $table->string('parameter_3_key')->nullable();
            $table->string('parameter_4_key')->nullable();
            $table->string('parameter_5_key')->nullable();
            $table->string('parameter_6_key')->nullable();
            $table->string('parameter_7_key')->nullable();
            $table->string('parameter_8_key')->nullable();
            $table->string('parameter_9_key')->nullable();
            $table->string('parameter_10_key')->nullable();
            $table->string('parameter_1_value',255)->nullable();
            $table->string('parameter_2_value',255)->nullable();
            $table->string('parameter_3_value',255)->nullable();
            $table->string('parameter_4_value',255)->nullable();
            $table->string('parameter_5_value',255)->nullable();
            $table->string('parameter_6_value',255)->nullable();
            $table->string('parameter_7_value',255)->nullable();
            $table->string('parameter_8_value',255)->nullable();
            $table->string('parameter_9_value',255)->nullable();
            $table->string('parameter_10_value',255)->nullable();
            $table->timestamps();
        });

        SmsGatewaySetting::create([
            'send_to_parameter_name' => ''
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_gateway_settings');
    }
}
