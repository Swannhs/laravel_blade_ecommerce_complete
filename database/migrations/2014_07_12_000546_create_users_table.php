<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('notification_preference')->default('mail');
            $table->boolean('is_active')->default(TRUE);
            $table->string('avatar')->nullable();
            $table->string('slug')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('description')->nullable();
            $table->boolean('secret_login')->default(0);
            $table->string('lang_code')->default('en');
            $table->unsignedBigInteger('currency_id')->default(2);
            $table->string('currency_code')->default('USD');
            $table->rememberToken();
            $table->timestamps();
        });

        User::create([
            'first_name' => 'Super Admin',
            'username' => '0181',
            'email' => 'superadmin@gmail.com',
            'role_id' => 1,
            'slug' => 'amaz-cart-1',
            'email_verified_at' => '2020-09-09 16:52:36',
            'password' => Hash::make(12345678)

        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
