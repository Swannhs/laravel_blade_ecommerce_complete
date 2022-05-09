<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\GeneralSetting\Entities\NotificationSetting;
use Modules\OrderManage\Entities\DeliveryProcess;

class CreateNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->string("event")->nullable();
            $table->unsignedBigInteger("delivery_process_id")->nullable();
            $table->string("type")->nullable();
            $table->string("message")->nullable();
            $table->boolean("user_access_status")->default(1);
            $table->boolean("seller_access_status")->default(0);
            $table->boolean("admin_access_status")->default(0);
            $table->boolean("staff_access_status")->default(0);
            $table->foreign("delivery_process_id")->on("delivery_processes")->references("id")->onDelete('cascade');
            $table->string('module')->nullable();
            $table->timestamps();
        });

        $sql = [
            ['delivery_process_id' => null, 'event' => 'Register', 'type' => 'system', 'message' => 'Welcome to the system.', 'user_access_status' => 0, 'seller_access_status' => 0, 'admin_access_status' => 0, 'staff_access_status' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['delivery_process_id' => null, 'event' => 'Offline recharge', 'type' => 'system', 'message' => 'Offline recharge successful', 'user_access_status' => 1, 'seller_access_status' => 1, 'admin_access_status' => 1, 'staff_access_status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['delivery_process_id' => null, 'event' => 'Withdraw request declined', 'type' => 'system', 'message' => 'Your withdraw request declined', 'user_access_status' => 1, 'seller_access_status' => 1, 'admin_access_status' => 1, 'staff_access_status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['delivery_process_id' => null, 'event' => 'Withdraw request approve', 'type' => 'system', 'message' => 'Withdraw request approve', 'user_access_status' => 1, 'seller_access_status' => 1, 'admin_access_status' => 1, 'staff_access_status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['delivery_process_id' => null, 'event' => 'Order confirmation', 'type' => 'system', 'message' => 'Order Confirmed', 'user_access_status' => 1, 'seller_access_status' => 1, 'admin_access_status' => 1, 'staff_access_status' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];


        $deliveryProcesses = DeliveryProcess::all();

        foreach ($deliveryProcesses as $deliveryProcess) {
            array_push($sql, ['delivery_process_id' => $deliveryProcess->id, 'event' => 'Order ' . $deliveryProcess->name, 'type' => 'system', 'message' => 'Order ' . $deliveryProcess->name, 'user_access_status' => 1, 'seller_access_status' => 1, 'admin_access_status' => 1, 'staff_access_status' => 1, 'created_at' => now(), 'updated_at' => now()]);
        }

        array_push($sql, ['delivery_process_id' => null, 'event' => 'Product review', 'type' => 'system', 'message' => 'Product review.', 'user_access_status' => 0, 'seller_access_status' => 1, 'admin_access_status' => 1, 'staff_access_status' => 0, 'created_at' => now(), 'updated_at' => now()]);
        array_push($sql, ['delivery_process_id' => null, 'event' => 'Product disable', 'type' => 'system', 'message' => 'Product disable.', 'user_access_status' => 0, 'seller_access_status' => 1, 'admin_access_status' => 0, 'staff_access_status' => 0, 'created_at' => now(), 'updated_at' => now()]);

        NotificationSetting::insert($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_settings');
    }
}
