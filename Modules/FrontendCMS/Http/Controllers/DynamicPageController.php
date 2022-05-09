<?php

namespace Modules\FrontendCMS\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FrontendCMS\Http\Requests\CreateDynamicPageRequest;
use Modules\FrontendCMS\Http\Requests\UpdateDynamicPageRequest;
use Modules\FrontendCMS\Services\DynamicPageService;
use Modules\UserActivityLog\Traits\LogActivity;

class DynamicPageController extends Controller
{
    protected $dynamicPageService;

    public function __construct(DynamicPageService $dynamicPageService)
    {
        $this->middleware('maintenance_mode');
        $this->dynamicPageService = $dynamicPageService;
    }
    public function index()
    {
        try {
            $pageList = $this->dynamicPageService->getAll();
            return view('frontendcms::dynamic_page.index', compact('pageList'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function create()
    {
        try {
            return view('frontendcms::dynamic_page.components.create');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function store(CreateDynamicPageRequest $request)
    {
        try {
            $this->dynamicPageService->save($request->only('title', 'slug', 'status', 'description'));

            Toastr::success(__('common.created_successfully'), __('common.success'));
            LogActivity::successLog('Dynamic Page created.');
            return redirect(route('frontendcms.dynamic-page.index'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }


    public function edit($id)
    {
        try {
            $pageInfo = $this->dynamicPageService->editById($id);
            return view('frontendcms::dynamic_page.components.edit', compact('pageInfo'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }


    public function update(UpdateDynamicPageRequest $request, $id)
    {
        try {
            $this->dynamicPageService->update($request->only('title', 'slug', 'status', 'description'), $id);

            Toastr::success(__('common.updated_successfully'),__('common.success'));
            LogActivity::successLog('Dynamic page updated.');
            return redirect(route('frontendcms.dynamic-page.index'));
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function destroy(Request $request)
    {
        try {
            $result =$this->dynamicPageService->deleteById($request->id);

            if ($result == "not_possible") {
                return response()->json([
                    'parent_msg' => 'Related Data Exist in Multiple Directory.'
                ]);
            }else{
                LogActivity::successLog('Dynamic page deleted.');
                return $this->loadTableData();
            }


        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'status'    =>  false,
                'message'   =>  $e->getMessage()
            ]);
        }

    }

    private function loadTableData()
    {
        try {
            $pageList = $this->dynamicPageService->getAll();

            return response()->json([
                'TableData' =>  (string)view('frontendcms::dynamic_page.components.list', compact('pageList'))
            ]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

    public function status(Request $request)
    {
        try {
            $data = [
                'status' => $request->status == 1 ? 0 : 1
            ];
            $this->dynamicPageService->statusUpdate($data, $request->id);
            LogActivity::successLog('Dynamic page status changed.');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
        return $this->loadTableData();
    }
}
