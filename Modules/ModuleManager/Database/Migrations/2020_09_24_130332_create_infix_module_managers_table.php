<?php

use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;
use Modules\ModuleManager\Entities\InfixModuleManager;

class CreateInfixModuleManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infix_module_managers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 250)->nullable();
            $table->string('email', 250)->nullable();
            $table->text('notes')->nullable();
            $table->string('version', 200)->nullable();
            $table->text('update_url')->nullable();
            $table->text('purchase_code')->nullable();
            $table->text('installed_domain')->nullable();
            $table->text('checksum')->nullable();
            $table->date('activated_date')->nullable();
            $table->timestamps();
        });

        $vendor = Storage::exists('.vendor')?Storage::get('.vendor'):'single';

        if(strtolower($vendor) == 'single'){
            InfixModuleManager::create([
                'name' => 'MultiVendor',
                'email' => 'support@spondonit.com'
            ]);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infix_module_managers');
    }
}
