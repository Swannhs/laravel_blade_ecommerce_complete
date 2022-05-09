<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEmailTemplateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_template_types', function (Blueprint $table) {
            $table->id();
            $table->string("type")->nullable();
            $table->string('module')->nullable();
            $table->timestamps();
        });
        DB::statement("INSERT INTO `email_template_types` (`id`, `type`, `created_at`, `updated_at`) VALUES
        (1, 'order_invoice_template', NULL, '2021-01-20 12:40:47'),
        (2, 'order_pending_template', NULL, '2021-01-20 12:40:47'),
        (3, 'order_confirmed_template', NULL, '2021-01-20 12:40:47'),
        (4, 'order_declined_template', NULL, '2021-01-20 12:40:47'),
        (5, 'paid_payment_template', NULL, '2021-01-20 12:40:47'),
        (6, 'order_completed_template', NULL, '2021-01-20 12:40:47'),
        (7, 'delivery_process_template', NULL, '2021-01-20 12:40:47'),
        (8, 'refund_pending_template', NULL, '2021-01-20 12:40:47'),
        (9, 'refund_confirmed_template', NULL, '2021-01-20 12:40:47'),
        (10, 'refund_declined_template', NULL, '2021-01-20 12:40:47'),
        (11, 'refund_money_paid_template', NULL, '2021-01-20 12:40:47'),
        (12, 'refund_money_pending_template', NULL, '2021-01-20 12:40:47'),
        (13, 'refund_completed_template', NULL, '2021-01-20 12:40:47'),
        (14, 'refund_process_template', NULL, '2021-01-20 12:40:47'),
        (15, 'gift_card_template', NULL, '2021-01-20 12:40:47'),
        (16, 'review_email_template', NULL, '2021-01-20 12:40:47'),
        (17, 'newsletter_email_template', NULL, '2021-01-20 12:40:47'),
        (18, 'wallet_email_template', NULL, '2021-01-20 12:40:47'),
        (19, 'order_email_template', NULL, '2021-01-20 12:40:47'),
        (20, 'register_email_template', NULL, '2021-01-20 12:40:47'),
        (21, 'notification_email_template', NULL, '2021-01-20 12:40:47'),
        (22, 'support_ticket_email_template', NULL, '2021-01-20 12:40:47'),
        (23, 'verification_email_template', NULL, '2021-01-20 12:40:47'),
        (24, 'product_review_email_template', NULL, '2021-01-20 12:40:47'),
        (28, 'product_disable_email_template', NULL, '2021-01-20 12:40:47'),
        (30, 'product_review_approve_email_template', NULL, '2021-01-20 12:40:47'),
        (31, 'product_update_email_template', NULL, '2021-01-20 12:40:47'),
        (32, 'withdraw_request_email_template', NULL, '2021-01-20 12:40:47')
        ");
        // last id 37
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_template_types');
    }
}
