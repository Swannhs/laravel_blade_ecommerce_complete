<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSmsTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("type_id")->nullable();
            $table->string("subject")->nullable();
            $table->longText("value")->nullable();
            $table->boolean("is_active")->default(0);
            $table->string('relatable_type')->nullable();
            $table->unsignedBigInteger('relatable_id')->nullable();
            $table->string('reciepnt_type')->nullable();
            $table->string('module')->nullable();
            $table->timestamps();
        });

        $sql = [
            ['id' => 1, 'type_id' => 1, 'subject' => 'Order Invoice', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'type_id' => 2, 'subject' => 'Order Pending', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'type_id' => 3, 'subject' => 'Order Confirmation', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'type_id' => 4, 'subject' => 'Order Declined', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'type_id' => 5, 'subject' => 'Paid Payment', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'type_id' => 6, 'subject' => 'Order Complete', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'type_id' => 8, 'subject' => 'Refund Pending', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'type_id' => 9, 'subject' => 'Refund Confirmation', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'type_id' => 10, 'subject' => 'Refund Declined', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'type_id' => 12, 'subject' => 'Refund Payment Pending', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'type_id' => 13, 'subject' => 'Refund Completed', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'type_id' => 14, 'subject' => 'Refund Processing', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'type_id' => 17, 'subject' => 'Bulk SMS', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'type_id' => 18, 'subject' => 'Order', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'type_id' => 19, 'subject' => 'Register', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'type_id' => 15, 'subject' => 'Giftcard Template', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'type_id' => 16, 'subject' => 'Review Template', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'type_id' => 21, 'subject' => 'Support Ticket', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'type_id' => 22, 'subject' => 'Wallet Offline Recharge', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'type_id' => 23, 'subject' => 'Wallet Online Recharge', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'type_id' => 24, 'subject' => 'withdraw_request_approve', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'type_id' => 25, 'subject' => 'withdraw_request_declined', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'type_id' => 26, 'subject' => 'Product disable Template', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('sms_templates')->insert($sql);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_templates');
    }
}
