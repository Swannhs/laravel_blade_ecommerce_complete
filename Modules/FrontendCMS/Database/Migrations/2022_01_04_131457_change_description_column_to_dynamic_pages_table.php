<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDescriptionColumnToDynamicPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('dynamic_pages')){
            DB::statement("ALTER TABLE `dynamic_pages` CHANGE `description` `description` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;");
        }
        Schema::table('dynamic_pages', function (Blueprint $table) {
            $table->string('module')->after('is_static')->nullable();
            $table->boolean('is_page_builder')->after('is_static')->default(0);
        });
    }

    public function down()
    {
        Schema::table('dynamic_pages', function (Blueprint $table) {
            $table->dropColumn('module');
            $table->dropColumn('is_page_builder');
        });
    }
}
