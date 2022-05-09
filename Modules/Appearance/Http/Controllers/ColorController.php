<?php

namespace Modules\Appearance\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Routing\Controller;
use Modules\Appearance\Http\Requests\ColorRequest;
use \Modules\Appearance\Services\ColorService;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Modules\Appearance\Entities\AdminColor;
use Modules\UserActivityLog\Traits\LogActivity;

class ColorController extends Controller
{

    protected $colorService;



    public function __construct(ColorService $colorService)
    {
        $this->colorService = $colorService;
        $this->middleware('maintenance_mode');
        $this->middleware('prohibited_demo_mode')->only('store','update');
    }



    public function index()
    {
        try {
            return view('appearance::color.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }


    public function get_data()
    {
        $data = $this->colorService->all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('title', function ($data) {
                return $data->title;
            })
            ->addColumn('type', function ($data) {
                return ucfirst($data->color_mode);
            })
            ->addColumn('color', function ($data) {

                return view('appearance::color.components.color_td', compact('data'));
            })
            ->addColumn('background', function ($data) {
                return view('appearance::color.components.background_td', compact('data'));
            })
            ->addColumn('status', function ($data) {
                return view('appearance::color.components.status_td', compact('data'));
            })
            ->addColumn('action', function ($data) {
                return view('appearance::color.components.action_td', compact('data'));
            })
            ->rawColumns(['status', 'action', 'color', 'background'])
            ->toJson();
    }



    public function create()
    {
        try {
            return view('appearance::color.create');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }



    public function edit($id)
    {
        try {
            $color = $this->colorService->getSingle($id);
            return view('appearance::color.edit', compact('color'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }



    public function clone($id)
    {
        try {
            $this->colorService->clone($id);
            Toastr::success(__('common.clone_successful'), __('common.success'));
            LogActivity::successLog('Color cloned successful.');
            return redirect()->route('appearance.color.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }



    public function store(ColorRequest $request)
    {
        try {
            $this->colorService->store($request);
            Toastr::success(__('common.added_successfully'), __('common.success'));
            LogActivity::successLog('Color created successful.');

            return redirect()->route('appearance.color.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }



    public function update(ColorRequest $request, $id)
    {
        try {
            $this->colorService->update($request, $id);
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('Color updated successful.');
            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }



    public function destroy($id)
    {
        try {
            $this->colorService->destroy($id);
            Toastr::success(__('common.deleted_successfully'), __('common.success'));
            LogActivity::successLog('Color deleted successful.');
            return redirect()->route('appearance.color.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }



    public function activate($id)
    {
        try {
            $this->colorService->activate($id);
            Toastr::success(__('common.activate_successful'), __('common.success'));
            LogActivity::successLog('Color activated successful.');
            return redirect()->route('appearance.color.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }
}
