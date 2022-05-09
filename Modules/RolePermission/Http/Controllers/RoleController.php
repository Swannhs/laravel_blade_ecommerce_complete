<?php

namespace Modules\RolePermission\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\RolePermission\Entities\Role;
use Modules\RolePermission\Http\Requests\RoleFormRequest;
use Modules\RolePermission\Repositories\RoleRepository;
use Modules\UserActivityLog\Traits\LogActivity;

class RoleController extends Controller
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->middleware(['auth','maintenance_mode']);
        $this->middleware('prohibited_demo_mode')->only('store','update','destroy');
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        try{
            $data['RoleList'] = $this->roleRepository->all();
            return view('rolepermission::role', $data);

        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }


    }

    public function create()
    {
        return view('rolepermission::create');
    }

    public function store(RoleFormRequest $request)
    {
        try {
            $this->roleRepository->create($request->except("_token"));
            LogActivity::successLog('New Role - ('.$request->name.') has been created.');
            Toastr::success(__('common.created_successfully'), __('common.success'));
            return redirect()->route('permission.roles.index');
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage().' - Error has been detected for Role creation');
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function show($id)
    {
        return view('rolepermission::show');
    }

    public function edit(Role $role)
    {
        try {
            $RoleList = $this->roleRepository->all();
            return view('rolepermission::role', compact('RoleList', 'role'));
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }

    public function update(RoleFormRequest $request, $id)
    {
        try {
            $role = $this->roleRepository->update($request->except("_token"), $id);
            if($role === true){
                LogActivity::successLog($request->name.'- has been updated.');
                Toastr::success(__('common.updated_successfully'), __('common.success'));
                return redirect(url('/hr/role-permission/roles'));
            }else{
                Toastr::error('Default Role Is Not Editable.');
                return redirect(url('/hr/role-permission/roles'));
            }
            
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage().' - Error has been detected for Role update');
            Toastr::error(__('common.error_message'), __('common.error'));
            return redirect()->route('permission.roles.index');
        }
    }

    public function destroy($id)
    {
        try {
            $role = $this->roleRepository->delete($id);
            if($role == 'not_possible'){
                Toastr::error(__('hr.delete_not_possible_role_has_user'), __('common.error'));
                return redirect()->back();
            }elseif($role == 'default_role'){
                Toastr::error('Default Role Is Not Deletable.');
                return redirect()->back();
            }
            LogActivity::successLog('A Role has been destroyed.');
            Toastr::success(__('common.deleted_successfully'), __('common.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage().' - Error has been detected for Role Destroy');
            return redirect()->back();
        }
    }
}
