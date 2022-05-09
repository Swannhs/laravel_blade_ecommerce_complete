<?php

namespace Modules\RolePermission\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Modules\ModuleManager\Entities\Module;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\RolePermission\Entities\Permission;
use Modules\RolePermission\Entities\Role;
use Modules\UserActivityLog\Traits\LogActivity;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenance_mode');
        $this->middleware('prohibited_demo_mode')->only('store');
    }



    public function index(Request $request)
    {
        

        try{
            $role = Role::with('permissions')->find($request['id']);
            if($role){
                if(!isModuleActive('MultiVendor') && $role->type == 'seller'){
                    return redirect(route('permission.roles.index'));
                }
                if($role->id == 1 || $role->type == 'customer'){
                    return redirect(route('permission.roles.index'));
                }
                if ($role->type == 'seller') {
                    $PermissionList = Permission::whereIn('module_id',['2','11','12','17','24','31','25','15','29','28','35','37'])->get();
                    $subModuleList = $PermissionList->where('type', 2)->whereIn('id', ['489','498','317', '514','505','506','507','508',
                    '509','510','511','163','164','165','166','167','154','155','156','157','158','159','160','161','17','18','19','20','21',
                    '22','23','24','25','492','493','494','495','532','533','534','535','536','569','571','574','609','615','625','619','620','621','624']);
                }elseif($role->type == 'staff' || $role->type == 'admin') {
                    $PermissionList = Permission::whereNotIn('module_id',['11','12','29','2','35','37'])->get();
                    $subModuleList = $PermissionList->where('type',2);
                }
                $data['role'] =  $role;
                $data['MainMenuList'] = $PermissionList->where('type',1);
                $data['SubMenuList'] = $subModuleList;
                $data['ActionList'] = $PermissionList->where('type',3);
                $data['PermissionList'] =  $PermissionList;
                return view('rolepermission::permission',$data);
            }else{
                return redirect(route('permission.roles.index'));
            }

        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => "required",
            'module_id' => "required|array"
        ]);

        if($validator->fails()){
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }

        try{
            DB::beginTransaction();
                $role  = Role::findOrFail($request->role_id);
                $role->permissions()->detach();
                $role->permissions()->attach(array_unique($request->module_id));
            DB::commit();
            LogActivity::successLog('Permission given Successfully');
            Toastr::success(__('hr.permission_given_successfully'), __('common.success'));
            return redirect()->back();
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollback();
           Toastr::error(__('common.error_message'), __('common.error'));
           return redirect()->back();
        }
    }
}
