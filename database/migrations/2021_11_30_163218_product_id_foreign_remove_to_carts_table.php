<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ProductIdForeignRemoveToCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try{
            DB::statement("ALTER TABLE carts DROP FOREIGN KEY carts_product_id_foreign;");
            DB::statement("ALTER TABLE `carts` DROP INDEX `carts_product_id_foreign`;");
        }catch(Exception $e){
            Log::info($e->getMessage());
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            
        });
    }
}
