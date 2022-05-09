<?php

namespace Modules\Appearance\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\UserActivityLog\Traits\LogActivity;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }
    
    public function index()
    {
        return view('appearance::dashboard.index');
    }

    
    public function update_status(Request $request)
    {
        try {
            app('dashboard_setup')->where('type', $request->type)->first()->update([
                'is_active' => $request->is_active
            ]);
            LogActivity::successLog('setup update status successful.');
            return 1;
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return 0;
        }

    }
    
}
