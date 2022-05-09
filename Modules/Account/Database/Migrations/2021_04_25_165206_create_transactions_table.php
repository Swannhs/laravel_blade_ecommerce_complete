<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->text('title')->nullable();

            $table->foreignId('chart_of_account_id')->nullable();

            $table->foreignId('bank_account_id')->nullable();

            $table->string('type', 30)->default('in');
            $table->string('payment_method', 30)->default('cash');
            $table->string('come_from', 20)->nullable();

            $table->text('description')->nullable();
            $table->text('file')->nullable();

            $table->unsignedBigInteger('morphable_id')->nullable();
            $table->string('morphable_type')->nullable();

            $table->double('amount')->default(0);
            $table->date('transaction_date')->nullable();

            $table->foreignId('created_by')->nullable();

            $table->foreignId('updated_by')->nullable();

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
         Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('transactions_chart_of_account_id_foreign');
            $table->dropForeign('transactions_bank_account_id_foreign');
            $table->dropForeign('transactions_created_by_foreign');
            $table->dropForeign('transactions_updated_by_foreign');
        });

        Schema::dropIfExists('transactions');
    }
}
