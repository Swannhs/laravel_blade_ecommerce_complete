<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Nwidart\Modules\Facades\Module;
use Modules\ModuleManager\Http\Controllers\ModuleManagerController;

class AddPageBuilderModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $moduleManagerController = new ModuleManagerController();
        $free_module = [
            'FormBuilder',
            'PageBuilder'
        ];
        foreach($free_module as $module){
            $active = Module::find($module);
            if(!$active || $active->isDisabled()){
                $moduleManagerController->FreemoduleAddOnsEnable($module);
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

    }
}
