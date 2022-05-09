<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\RolePermission\Entities\Permission;
use Modules\SidebarManager\Entities\Sidebar;

class AddRowCustomerCrudPermissionToPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permission_sql = [
            ['id'  => 645, 'module_id' => 5, 'parent_id' => 82, 'name' => 'Create', 'route' => 'admin.customer.create', 'type' => 2 ],
            ['id'  => 646, 'module_id' => 5, 'parent_id' => 82, 'name' => 'Update', 'route' => 'admin.customer.edit', 'type' => 2 ],
            ['id'  => 647, 'module_id' => 5, 'parent_id' => 82, 'name' => 'Delete', 'route' => 'admin.customer.destroy', 'type' => 2 ]
        ];

        try{
            DB::table('permissions')->insert($permission_sql);
        }catch(Exception $e){

        }
        $sidebar_sql = [
            ['sidebar_id' => 66, 'module_id' => 14, 'parent_id' => 63, 'name' => 'Inhouse Orders', 'route' => 'admin.inhouse-order.get-data', 'type' => 2]
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::destroy([645,646,647]);
        $sidebars = Sidebar::whereIn('sidebar_id', [66])->pluck('id');
        Sidebar::destroy($sidebars);
    }
}
