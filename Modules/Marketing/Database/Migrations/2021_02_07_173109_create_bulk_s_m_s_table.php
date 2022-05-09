<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBulkSMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_s_m_s', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->date('publish_date');
            $table->unsignedInteger('send_type');
            $table->text('send_user_ids');
            $table->string('multiple_role_id')->nullable();
            $table->unsignedTinyInteger('single_role_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_send')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bulk_s_m_s');
    }
}
