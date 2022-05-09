<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\GeneralSetting\Entities\BusinessSettings;

class CreateBusinessSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_settings', function (Blueprint $table) {
            $table->id();
            $table->string("category_type", 200)->nullable();
            $table->string("type", 200)->nullable();
            $table->mediumInteger("status")->default(0);
            $table->timestamps();
        });

        DB::table('business_settings')->insert([
            [
                'category_type' => 'verification and notifications',
                'type' => 'email_verification',
                'status' => '0',
                'created_at' => date('Y-m-d h:i:s')
            ],
            [
                'category_type' => 'verification and notifications',
                'type' => 'sms_verification',
                'status' => '0',
                'created_at' => date('Y-m-d h:i:s')
            ],
            [
                'category_type' => 'verification and notifications',
                'type' => 'mail_notification',
                'status' => '0',
                'created_at' => date('Y-m-d h:i:s')
            ],
            [
                'category_type' => 'verification and notifications',
                'type' => 'system_notification',
                'status' => '0',
                'created_at' => date('Y-m-d h:i:s')
            ],
            [
                'category_type' => 'sms_gateways',
                'type' => 'Twillo',
                'status' => '0',
                'created_at' => date('Y-m-d h:i:s')
            ],
            [
                'category_type' => 'sms_gateways',
                'type' => 'TextLocal',
                'status' => '0',
                'created_at' => date('Y-m-d h:i:s')
            ],
            [
                'category_type' => 'vendor_configuration',
                'type' => 'Multi-Vendor System Activate',
                'status' => '0',
                'created_at' => date('Y-m-d h:i:s')
            ],
            [
                'category_type' => 'refund_config',
                'type' => 'refund_status',
                'status' => '0',
                'created_at' => date('Y-m-d h:i:s')
            ],
            [
                'category_type' => 'refund_config',
                'type' => 'refund_times',
                'status' => '1',
                'created_at' => date('Y-m-d h:i:s')
            ],
            [
                'category_type' => 'voucher',
                'type' => 'payroll_voucher_approval',
                'status' => '0',
                'created_at' => date('Y-m-d h:i:s')
            ],
            [
                'category_type' => 'analytics_tool',
                'type' => 'google_analytics',
                'status' => 0,
                'created_at' => date('Y-m-d h:i:s')
            ],
            [
                'category_type' => 'analytics_tool',
                'type' => 'facebook_pixel',
                'status' => 0,
                'created_at' => date('Y-m-d h:i:s')
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
        Schema::dropIfExists('business_settings');
    }
}
