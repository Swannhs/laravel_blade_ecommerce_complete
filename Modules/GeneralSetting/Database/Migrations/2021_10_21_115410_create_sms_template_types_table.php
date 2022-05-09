<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSmsTemplateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_template_types', function (Blueprint $table) {
            $table->id();
            $table->string("type")->nullable();
            $table->string('module')->nullable();
            $table->timestamps();
        });

        $sql = [
            ['id' => 1, 'type' => 'order_invoice_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'type' => 'order_pending_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'type' => 'order_confirmed_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'type' => 'order_declined_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'type' => 'paid_payment_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'type' => 'order_completed_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'type' => 'delivery_process_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'type' => 'refund_pending_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'type' => 'refund_confirmed_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'type' => 'refund_declined_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'type' => 'refund_money_paid_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'type' => 'refund_money_pending_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'type' => 'refund_completed_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'type' => 'refund_process_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'type' => 'gift_card_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'type' => 'review_sms_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'type' => 'bulk_sms_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'type' => 'order_sms_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'type' => 'register_sms_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'type' => 'notification_sms_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'type' => 'support_ticket_sms_template', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'type' => 'wallet_offline_recharge', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'type' => 'wallet_online_recharge', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'type' => 'withdraw_request_approve', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 25, 'type' => 'withdraw_request_declined', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 26, 'type' => 'Product disable', 'created_at' => now(), 'updated_at' => now()]
        ];
        DB::table('sms_template_types')->insert($sql);
        //last id 37
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_template_types');
    }
}
