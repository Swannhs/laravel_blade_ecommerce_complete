<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\RolePermission\Entities\Permission;
use Modules\SidebarManager\Entities\Sidebar;

class AddPermissionSidebarForConfigurationMarketingModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = [
            ['id'  => 636, 'module_id' => 10, 'parent_id' => 122, 'name' => 'Configuration', 'route' => 'marketing.configuration', 'type' => 2 ]
        ];
        if(Schema::hasTable('permissions')){
            DB::table('permissions')->insert($sql);
        }

        $sql = [
            ['sidebar_id' => 189, 'module_id' => 10, 'parent_id' => 38, 'name' => 'Configuration', 'route' => 'marketing.configuration', 'type' => 2,'position' => 10],
        ];

        $users =  User::whereHas('role', function($query){
            $query->where('type', 'superadmin')->orWhere('type', 'admin')->orWhere('type', 'staff')->orWhere('type', 'seller');
        })->pluck('id');

        foreach ($users as $key=> $user)
        {
            $user_array[$key] = ['user_id' => $user];
            foreach ($sql as $row)
            {
                $final_row = array_merge($user_array[$key],$row);
                Sidebar::insert($final_row);
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
        Permission::destroy([636]);
        $sidebars = Sidebar::whereIn('sidebar_id', [189])->pluck('id');
        Sidebar::destroy($sidebars);
    }
}
