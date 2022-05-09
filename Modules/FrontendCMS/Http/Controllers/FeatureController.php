<?php

namespace Modules\FrontendCMS\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FrontendCMS\Http\Requests\CreateFeatureRequest;
use Modules\FrontendCMS\Http\Requests\UpdateFeatureRequest;
use \Modules\FrontendCMS\Services\FeatureService;
use Modules\UserActivityLog\Traits\LogActivity;

class FeatureController extends Controller
{
    protected $featureService;

    public function __construct(FeatureService $featureService)
    {
        $this->middleware('maintenance_mode');
        $this->featureService = $featureService;
    }

    public function index()
    {
        try {
            $data['FeatureList'] = $this->featureService->getAll();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
        return view('frontendcms::feature.index', $data);
    }

    public function list()
    {
        $FeatureList = $this->featureService->getAll();
        return view('frontendcms::feature.componant.list', compact('FeatureList'));
    }

    public function store(CreateFeatureRequest $request)
    {
        try {
            $this->featureService->save($request->only('title', 'slug', 'icon', 'status'));

            LogActivity::successLog('Feature added.');

            return $this->loadTableData();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'status' => false,
                'error' => $e
            ]);
        }

    }

    public function show($id)
    {
        try {
            $feature = $this->featureService->showById($id);
            return response()->json([
                'status' => true,
                'TableData' =>  (string)view('frontendcms::feature.components.list', compact('FeatureList'))
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'status' => false,
                'error' => $e
            ]);
        }
        return view('frontendcms::show');
    }

    public function edit($id){

        $feature = $this->featureService->showById($id);
        return view('frontendcms::feature.components.edit',compact('feature'));
    }

    public function update(UpdateFeatureRequest $request)
    {
        try {
            $result = $this->featureService->update($request->only('title', 'slug', 'icon', 'status'), $request->id);
            LogActivity::successLog('Feature Updated.');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'status' => false,
                'error' => $e
            ]);
        }
        return  $this->loadTableData();
    }

    public function delete(Request $request)
    {
        try {
            $this->featureService->deleteById($request['id']);
            LogActivity::successLog('Feature Deleted.');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'status' => false,
                'error' => $e,
            ]);
        }

        return  $this->loadTableData();
    }

    private function loadTableData()
    {
        try {
            $FeatureList = $this->featureService->getAll();
            return response()->json([
                'status' => true,
                'TableData' =>  (string)view('frontendcms::feature.components.list', compact('FeatureList')),
                'createForm' =>  (string)view('frontendcms::feature.components.create')
            ]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'status' => false,
                'error' => $e
            ]);
        }
    }
}
