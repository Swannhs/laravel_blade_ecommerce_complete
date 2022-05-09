<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\GeneralSetting\Entities\NotificationSetting;
use Modules\GeneralSetting\Entities\UserNotificationSetting;

class CreateUserNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('user_notification_settings')){
            Schema::create('user_notification_settings', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("user_id")->nullable();
                $table->unsignedBigInteger("notification_setting_id")->nullable();
                $table->foreign("user_id")->on("users")->references("id")->onDelete('cascade');
                $table->foreign("notification_setting_id")->on("notification_settings")->references("id")->onDelete('cascade');
                $table->string("type")->nullable();
                $table->timestamps();
            });
            $users = User::all();

            foreach($users as $user){
                $notificationSettings =(new NotificationSetting())->getNotificationSettingByUserRoleType($user->id);
                foreach($notificationSettings as $notificationSetting){
                    UserNotificationSetting::create([
                        'user_id' => $user->id,
                        'notification_setting_id' =>  $notificationSetting->id,
                        'type' => $notificationSetting->type
                    ]);
                }
            }
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_notification_settings');
    }
}
