<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Modules\RolePermission\Entities\Permission;
use Modules\UserActivityLog\Traits\LogActivity;

class SearchController extends Controller
{
    function search(Request $r)
    {
        try {
            if ($r->ajax()) {
                $output = '';
                $query = $r->get('search');

                if ($query != '') {
                    if (Auth::user()->role->type == 'superadmin') {
                        $permission = Permission::query();
                         $data = $permission->where('name', 'LIKE', '%' . $query . '%')
                         ->where('route', 'NOT LIKE', '%get-data%')
                            ->orderBy('id', 'desc')
                            ->where(function ($query) {
                                $query->where('route', 'NOT LIKE', '%destroy%')->orWhere('route', 'NOT LIKE', '%edit%')->orWhere('route', 'NOT LIKE', '%update%')
                                    ->where('route', 'NOT LIKE', '%status%')->where('route', 'NOT LIKE', '%view%')->where('route', 'NOT LIKE', '%delete%')->where('route', 'NOT LIKE', '%history%');
                            })->get();
                            $i = 0;
                        if (count($data) > 0) {
                            foreach ($data as $row) {
                                if(!$row->module or isModuleActive($row->module)){
                                    if (Route::has($row->route)){
                                        $route = route(''.$row->route.'');
                                        if($row->route == 'seller_report.review' || (isModuleActive('MultiVendor') && $row->name == 'Company Reviews')){
                                            continue;
                                        }
                                        $output .= "<a href='".$route."'>".$row->name."</a>";


                                    }
                                }
                            }
                        } else {
                            $no_result = trans('common.no_results_found');
                            $output .= "<a href='#'>$no_result</a>";
                        }

                        return $output;
                    } else {
                        $permission = DB::table('permissions');

                        $data = $permission->join('role_permission', 'permissions.id', '=', 'role_permission.permission_id')
                            ->where('name', 'like', '%' . $query . '%')
                            ->where(function ($query) {
                                $query->where('route', 'NOT LIKE', '%destroy%')->orWhere('route', 'NOT LIKE', '%edit%')->orWhere('route', 'NOT LIKE', '%update%')
                                    ->where('route', 'NOT LIKE', '%status%')->where('route', 'NOT LIKE', '%view%')->where('route', 'NOT LIKE', '%delete%')->where('route', 'NOT LIKE', '%history%');
                            })->where('role_id', Auth::user()->role_id)
                            ->get();
                        if (count($data) > 0) {
                            foreach ($data as $row) {
                                if(!$row->module or isModuleActive($row->module)){
                                    if (Route::has($row->route)){
                                        $route = route(''.$row->route.'');
                                        $output .= "<a href='".$route."'>".$row->name."</a>";

                                    }
                                }
                            }
                        } else {
                            $no_result = trans('common.no_results_found');
                            $output = "<a href='#'>$no_result</a>";
                        }
                        return $output;
                    }
                } else {
                    return response()->json(['not found' => 'Not Found'], 404);
                }
            }
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());

        }
    }
}
