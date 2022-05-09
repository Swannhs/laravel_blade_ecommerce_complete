<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\SidebarManager\Entities\Sidebar;

class CreateFormBuilderPermissionTable extends Migration
{

    public function up()
    {
        $permission = [
            ['id' => 667, 'module_id' => 42, 'parent_id' => null, 'module' => 'FormBuilder', 'name' => 'Form Builder', 'route' => 'form_builder', 'type' => 1],
            ['id' => 668, 'module_id' => 42, 'parent_id' => 667, 'module' => 'FormBuilder', 'name' => 'Forms', 'route' => 'form_builder.forms.index', 'type' => 2],
            ['id' => 669, 'module_id' => 42, 'parent_id' => 668, 'module' => 'FormBuilder', 'name' => 'List', 'route' => 'form_builder.forms.index', 'type' => 3],
            ['id' => 670, 'module_id' => 42, 'parent_id' => 668, 'module' => 'FormBuilder', 'name' => 'Form Builder', 'route' => 'form_builder.builder', 'type' => 3],
            ['id' => 671, 'module_id' => 42, 'parent_id' => 668, 'module' => 'FormBuilder', 'name' => 'View', 'route' => 'form_builder.forms.show', 'type' => 3],
        ];

        try{
            DB::table('permissions')->insert($permission);
        }catch(Exception $e){

        }

        $sidebar_sql = [
            ['sidebar_id' => 184, 'module_id' => 39, 'parent_id' => null,'position' => 4, 'module' => 'FormBuilder', 'name' => 'Form Builder', 'route' => 'form_builder', 'type' => 1],
            ['sidebar_id' => 185, 'module_id' => 39, 'parent_id' => 184, 'position' => 1, 'module' => 'FormBuilder', 'name' => 'Forms', 'route' => 'form_builder.forms.index', 'type' => 2],
        ];


        try{
            $users =  User::whereHas('role', function($query){
                $query->where('type', 'superadmin')->orWhere('type', 'admin')->orWhere('type', 'staff')->orWhere('type', 'seller');
            })->pluck('id');

            foreach ($users as $key=> $user)
            {
                $user_array[$key] = ['user_id' => $user];
                foreach ($sidebar_sql as $row)
                {
                    $final_row = array_merge($user_array[$key],$row);
                    Sidebar::insert($final_row);
                }
            }
        }catch(Exception $e){

        }
    }


    public function down()
    {
        Schema::dropIfExists('form_builder_permission');
    }
}
