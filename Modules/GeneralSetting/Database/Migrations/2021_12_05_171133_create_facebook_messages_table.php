<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\GeneralSetting\Entities\FacebookMessage;
use Modules\RolePermission\Entities\Permission;
use Modules\SidebarManager\Entities\Sidebar;

class CreateFacebookMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facebook_messages', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(0);
            $table->longText('code')->nullable();
            $table->timestamps();
        });

        FacebookMessage::create([
            'status' => 0,
            'code' => null
        ]);


        $permission_sql = [
            ['id'  => 642, 'module_id' => 18, 'parent_id' => 329, 'name' => 'Social Configuration', 'route' => 'generalsetting.social_login_configuration', 'type' => 2 ],
            ['id'  => 643, 'module_id' => 18, 'parent_id' => 642, 'name' => 'Social Login Update', 'route' => 'generalsetting.social_login_configuration.update', 'type' => 3 ],
            ['id'  => 644, 'module_id' => 18, 'parent_id' => 642, 'name' => 'Messanger Chat Update', 'route' => 'generalsetting.messangerChat.update', 'type' => 3 ]
        ];
        try{
            DB::table('permissions')->insert($permission_sql);
        }catch(Exception $e){
            
        }
        

        $sidebar_sql = [
            ['sidebar_id' => 173, 'module_id' => 16, 'parent_id' => 75, 'name' => 'Social Configuration', 'route' => 'generalsetting.social_login_configuration', 'type' => 2]
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
        Schema::dropIfExists('facebook_messages');
        Permission::destroy([642,643,644]);

        $sidebars = Sidebar::whereIn('sidebar_id', [173])->pluck('id');
        Sidebar::destroy($sidebars);

    }
}
