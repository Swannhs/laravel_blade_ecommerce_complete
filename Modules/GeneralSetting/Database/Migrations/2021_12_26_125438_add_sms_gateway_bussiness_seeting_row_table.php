<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSmsGatewayBussinessSeetingRowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try{
            \Modules\GeneralSetting\Entities\BusinessSetting::create(
                [
                    'category_type' => 'sms_gateways',
                    'type' => 'OtherSmsGateway',
                    'status' => '0',
                ]
            );
        }catch(Exception $e){

        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try{
            $row = \Modules\GeneralSetting\Entities\BusinessSetting::where('category_type','sms_gateways')->where('type','OtherSmsGateway')->first();
            if($row){
                $row->delete();
            }
        }catch(Exception $e){

        }


    }
}
