<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Refund\Entities\RefundProcess;

class CreateRefundProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_processes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        RefundProcess::create(['name' => 'Start', 'description' => 'The refund process has been started.']);
        RefundProcess::create(['name' => 'Processing', 'description' => 'The refund is processing.']);
        RefundProcess::create(['name' => 'Complete', 'description' => 'The refund is completed.']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refund_processes');
    }
}
