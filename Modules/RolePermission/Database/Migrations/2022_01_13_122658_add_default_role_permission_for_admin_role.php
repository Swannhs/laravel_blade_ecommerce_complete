<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddDefaultRolePermissionForAdminRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('role_permission')){
            $lists = [
                ['permission_id' => 1,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 2,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 16,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 17,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 18,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 19,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 20,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 21,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 22,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 23,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 24,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 25,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 153,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 154,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 155,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 156,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 157,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 158,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 159,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 160,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 161,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 175,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 198,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 199,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 200,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 201,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 202,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 203,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 204,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 205,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 206,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 207,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 208,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 209,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 210,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 213,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 214,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 215,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 216,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 217,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 218,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 279,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 290,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 291,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 292,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 293,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 294,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 295,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 296,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 297,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 298,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 299,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 300,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 301,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 302,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 303,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 304,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 305,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 306,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 307,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 308,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 309,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 310,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 311,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 464,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 465,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 407,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 408,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 409,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 410,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 411,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 412,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 413,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 414,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 415,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 416,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 417,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 418,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 419,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 420,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 421,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 422,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 423,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 424,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 425,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 426,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 427,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 428,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 429,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 430,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 431,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 432,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 496,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 497,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 516,'role_id' => 2,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')]
            ];

            $exsist = DB::table('role_permission')->where('role_id', 2)->where('permission_id', 1)->first();
            if(!$exsist){
                DB::table('role_permission')->insert($lists);
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
        Schema::table('', function (Blueprint $table) {

        });
    }
}
