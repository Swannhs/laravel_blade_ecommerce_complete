<?php

namespace Modules\SidebarManager\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\SidebarManager\Entities\Sidebar;

class SidebarManagerController extends Controller
{

    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }

    public function index()
    {
        try {
            if (!Auth::user()->sidebars()->exists())
            {
                $sidebars = Sidebar::where('user_id',1)->orderBy('position','asc')->get();
                foreach ($sidebars as $sidebar)
                {
                    $data = $sidebar->toArray();
                    $data['user_id'] = auth()->id();

                    Sidebar::create($data);
                }
            }
           
            $role_id = auth()->user()->role_id;
            if ($role_id == 'seller') {
                $PermissionList = Sidebar::where('user_id',auth()->id())->orderBy('position','asc')->whereIn('module_id', ['7','13','30','15','21','25','26','27','28','29','32','34'])->get();
                $subMenuList = $PermissionList->where('type', 2)->whereIn('sidebar_id', ['30','31','61','62', '135','72','106','124','125','126','127','128','129','130','131','152','153','154','155','156','167']);
            }else{
                $PermissionList = Sidebar::where('user_id',auth()->id())->whereNotIn('module_id', ['27','28','29','30','32','34'])->orderBy('position','asc')->get();
                $subMenuList = $PermissionList->where('type', 2);
            }

            $data['MainMenuList'] = $PermissionList->where('type', 1);
            $data['PermissionList'] = $PermissionList;
            $data['SubMenuList'] = $subMenuList;
            $data['role'] = auth()->user()->role;
            $data['permissions'] = $data['role']->permissions;
            $data['ActionList'] = $PermissionList->where('type',3);
            return view('sidebarmanager::index')->with($data);
        } catch (\Exception $e) {
            Toastr::error(trans('common.error_message'));
            return back();
        }
    }

    public function store(Request $request)
    {   
        try {
            DB::beginTransaction();
            foreach ($request->module_id as $key => $module) {
                $sidebar = Sidebar::where('module_id', $module)->where('user_id', auth()->id())->where('type', 1)->first();
                if ($sidebar)
                {
                    $sidebar->position = $request->menu_positions[$key];
                    $sidebar->status = $request->status[$key];
                    $sidebar->save();
                }

            }

            if($request->has('sub_module_id') && is_array($request->sub_module_id)){
                foreach ($request->sub_module_id as $key => $sub_module) {

                    $sidebar = Sidebar::where('user_id', auth()->id())->where('sidebar_id', $sub_module)->where('type', 2)->first();
                    
                    if ($sidebar)
                    {
                        $sidebar->position = $request->sub_positions[$key];
                        $sidebar->status = $request->sub_status[$key];
                        $sidebar->save();
                    }

                }
            }
            session()->forget('menus');
            DB::commit();
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            return back();
            
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error(__('common.error_message'));
            return back();
        }
    }
}
