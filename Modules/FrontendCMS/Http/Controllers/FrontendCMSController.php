<?php

namespace Modules\FrontendCMS\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use \Modules\GeneralSetting\Repositories\GeneralSettingRepository;
use Modules\UserActivityLog\Traits\LogActivity;

class FrontendCMSController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }

    public function index()
    {
        return view('frontendcms::index');
    }

    public function title_index()
    {
        return view('frontendcms::title_settings.index');
    }

    public function title_update(Request $request)
    {
        try {
            $generalSettingService = new GeneralSettingRepository();
            $generalSettingService->update($request->except("_token"));
            LogActivity::successLog('Title updated.');
            Toastr::success(__('frontendCms.title_has_been_updated_successfully'), __('common.success'));
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }
}
