<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateChartOfAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();

            $table->string('code')->nullable();
            $table->string('type')->nullable();
            $table->string('default_for')->nullable();

            $table->string('name')->nullable();
            $table->bigInteger('opening_balance')->default(0);
            $table->text("description")->nullable();

            $table->tinyInteger("level")->default(0);

            $table->string("morphable_type", 255)->nullable();
            $table->unsignedBigInteger("morphable_id")->nullable();

            $table->boolean("status")->default(true);

            $table->foreignId('parent_id')->nullable();

            $table->foreignId('created_by')->nullable();

            $table->foreignId('updated_by')->nullable();

            $table->timestamps();
        });

        $sql = [
            ['id' => 1, 'code' => 'income-1','type' => 'Income','default_for' => 'Income', 'name' => 'Main Income', 'opening_balance' => 0, 'description' => 'this is for main income from system', 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'code' => 'income-2','type' => 'Income','default_for' => 'Seller Account', 'name' => 'Main Seller Account', 'opening_balance' => 0, 'description' => 'This is for seller account', 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'code' => 'Income-3','type' => 'Income','default_for' => 'Product Wise Tax Account', 'name' => 'Product TAX', 'opening_balance' => 0, 'description' => 'This is for product tax', 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'code' => 'liability-1','type' => 'Liability','default_for' => 'GST Tax Account', 'name' => 'GST TAX', 'opening_balance' => 0, 'description' => 'This is for GST', 'created_by' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('chart_of_accounts')->insert($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chart_of_accounts', function (Blueprint $table) {
            $table->dropForeign('chart_of_accounts_parent_id_foreign');
            $table->dropForeign('chart_of_accounts_created_by_foreign');
            $table->dropForeign('chart_of_accounts_updated_by_foreign');
        });

        Schema::dropIfExists('chart_of_accounts');
    }
}
