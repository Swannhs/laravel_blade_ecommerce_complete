<?php

namespace Modules\FrontendCMS\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FrontendCMS\Http\Requests\UpdateContactContentRequest;
use \Modules\FrontendCMS\Services\ContactContentService;
use \Modules\FrontendCMS\Services\QueryService;
use Exception;
use Modules\FrontendCMS\Http\Requests\QueryRequest;
use Modules\UserActivityLog\Traits\LogActivity;

class ContactContentController extends Controller
{
    protected $contactContentService;
    protected $queryService;

    public function __construct(ContactContentService $contactContentService, QueryService $queryService)
    {
        $this->middleware('maintenance_mode');
        $this->contactContentService = $contactContentService;
        $this->queryService = $queryService;
    }

    public function index()
    {
        try{
            $contactContent = $this->contactContentService->getAll();
            $QueryList = $this->queryService->getAll();
            return view('frontendcms::contact_content.index', compact('contactContent','QueryList'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'status'    =>  false,
                'message'   =>  $e->getMessage()
            ]);
        }


    }

    public function update(UpdateContactContentRequest $request)
    {
        try {
            $update = $this->contactContentService->update($request->only('mainTitle', 'subTitle', 'slug', 'email', 'description'), $request->id);
            LogActivity::successLog('contact content update successful.');
            return $update;

        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'status'    =>  false,
                'message'   =>  $e->getMessage()
            ]);
        }
    }

    public function queryCreate(){
        try {
            return response()->json([
                'editHtml' => (string)view('frontendcms::contact_content.components.create_query')
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function queryStore(QueryRequest $request){

        try{
            $this->queryService->save($request->only('name','status'));
            LogActivity::successLog('Query Added.');
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
        return $this->loadTableData();
    }

    public function status(Request $request)
    {
        try {
            $data = [
                'status' => $request->status == 1 ? 0 : 1
            ];
            $this->queryService->statusUpdate($data, $request->id);
            LogActivity::successLog('contact content status update');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
        return $this->loadTableData();
    }

    public function queryEdit($id){
        try {
            $query = $this->queryService->editById($id);
            return response()->json([
                'editHtml' => (string)view('frontendcms::contact_content.components.edit_query'),
                'data' => $query
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function queryUpdate(QueryRequest $request){

        try{
            $this->queryService->update($request->only('name','status'),$request->id);
            LogActivity::successLog('Query Updated.');
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
        return $this->loadTableData();
    }

    public function destroy(Request $request)
    {
        try {
            $this->queryService->deleteById($request->id);
            LogActivity::successLog('Query Deleted.');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'status'    =>  false,
                'message'   =>  $e->getMessage()
            ]);
        }

        return $this->loadTableData();
    }


    private function loadTableData()
    {

        try {
            $QueryList = $this->queryService->getAll();

            return response()->json([
                'TableData' =>  (string)view('frontendcms::contact_content.components.query_list', compact('QueryList'))
            ]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }
}
