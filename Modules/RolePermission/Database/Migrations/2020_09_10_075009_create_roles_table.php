<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('details')->nullable();
            $table->string('module')->nullable(); 
            $table->timestamps();
        });


        $sql = [
            ['id' => 1, 'name' => 'Super admin', 'type' => 'superadmin', 'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
            ['id' => 2, 'name' => 'Admin', 'type' => 'admin', 'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
            ['id' => 3, 'name' => 'Staff', 'type' => 'staff', 'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
            ['id' => 4, 'name' => 'Customer', 'type' => 'customer', 'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')]
        ];


        DB::table('roles')->insert($sql);
        //last role id 6

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
