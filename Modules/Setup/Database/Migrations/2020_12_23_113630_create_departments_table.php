<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Setup\Entities\Department;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('details')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Department::insert([
            [
                'name' => 'Sales',
                'details' => 'Sales Department',
                'status' => true
            ],
            [
                'name' => 'Marketing',
                'details' => 'Marketing Department',
                'status' => true
            ],
            [
                'name' => 'HR',
                'details' => 'HR Department',
                'status' => true
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
