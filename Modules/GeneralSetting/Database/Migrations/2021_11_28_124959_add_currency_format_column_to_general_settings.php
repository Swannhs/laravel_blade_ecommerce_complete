<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrencyFormatColumnToGeneralSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('general_settings', function (Blueprint $table) {
            if(!Schema::hasColumn('general_settings','currency_symbol_position')){
                $table->string('currency_symbol_position')->default('left_with_space')->after('commission_by');
            }
            if(!Schema::hasColumn('general_settings','decimal_limit')){
                $table->unsignedInteger('decimal_limit')->default(2)->after('currency_symbol_position');
            }
            if(!Schema::hasColumn('general_settings','default_country')){
                $table->unsignedBigInteger('default_country')->default(18)->nullable()->after('decimal_limit');
            }
            if(!Schema::hasColumn('general_settings','default_state')){
                $table->unsignedBigInteger('default_state')->default(348)->nullable()->after('default_country');
            }
            if(!Schema::hasColumn('general_settings','guest_checkout')){
                $table->boolean('guest_checkout')->default(1)->after('default_state');
            }
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropColumn('currency_symbol_position');
            $table->dropColumn('decimal_limit');
            $table->dropColumn('default_country');
            $table->dropColumn('default_state');
            $table->dropColumn('guest_checkout');
        });
    }
}
