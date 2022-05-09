<?php

namespace Modules\Appearance\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Routing\Controller;
use Modules\Appearance\Http\Requests\ThemeColorRequest;
use \Modules\Appearance\Services\ThemeColorService;
use Exception;
use Illuminate\Http\Request;
use Modules\UserActivityLog\Traits\LogActivity;

class ThemeColorController extends Controller
{

    protected $themeColorService;



    public function __construct(ThemeColorService $themeColorService)
    {
        $this->themeColorService = $themeColorService;
        $this->middleware('maintenance_mode');
    }



    public function index(Request $request)
    {
        try {
            $id = $request->id;
            if ($id) {
                $themeColor = $this->themeColorService->getSingle($id);
            } else {
                $themeColor = $this->themeColorService->activeColor();
            }

            $themeColors = $this->themeColorService->getAll();
            return view('appearance::theme_color.index', compact('themeColor', 'themeColors'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }




    public function update(ThemeColorRequest $request, $id)
    {
        try {
            $this->themeColorService->update($request, $id);
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('theme color updated successful.');
            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }



    public function activate($id)
    {
        try {
            $this->themeColorService->activate($id);
            Toastr::success(__('common.activate_successful'), __('common.success'));
            LogActivity::successLog('theme color activated successful.');
            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }
}
