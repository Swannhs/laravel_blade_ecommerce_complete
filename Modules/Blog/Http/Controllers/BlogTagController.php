<?php

namespace Modules\Blog\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Services\BlogTagService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Modules\UserActivityLog\Traits\LogActivity;

class BlogTagController extends Controller
{

    protected $blogTagService;

    public function __construct(BlogTagService $blogTagService)
    {
        $this->blogTagService = $blogTagService;
        $this->middleware('maintenance_mode');
        $this->middleware('prohibited_demo_mode')->only('store','update','destroy');
    }

    public function index()
    {
        try{
            $data['itemList']  = $this->blogTagService->getAll();
            return view('blog::tag.tag',$data);
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }

    public function getData(){

        $value = $this->blogTagService->getAll();

        return DataTables::of($value)
            ->addIndexColumn()
            ->addColumn('name', function($value){
                return Str::limit($value->name,15);
            })
            ->addColumn('action', function($value){
                return view('blog::tag.components._action_td',compact('value'));
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function store(Request $request)
    {
         $request->validate([
                'name' => 'required|string|unique:blog_tags,name'
            ]);

         try{

            $this->blogTagService->create(['name' => $request['name']]);
            Toastr::success(__('common.operation_done_successfully'),__('common.success'));
            LogActivity::successLog('blog tag added.');
            return redirect()->back();
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }

    public function edit($id)
    {
       try{
            $data['itemList']  = $this->blogTagService->getAll();
            $data['editData']   = $this->blogTagService->find($id);
            return view('blog::tag.tag',$data);
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }


    public function update(Request $request, $id)
    {
       $request->validate([
                'name' => 'required|string|unique:blog_tags,name,'.$id
            ]);
        try{

            $this->blogTagService->update(['name' => $request['name']],$id);
            Toastr::success(__('common.operation_done_successfully'),__('common.success'));

            LogActivity::successLog('blog tag updated.');
            return redirect()->route('blog.tags.index');
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
             return $e->getMessage().$e->getLine();
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }


    public function destroy($id)
    {
        try{
            $this->blogTagService->delete($id);
            Toastr::success(__('common.operation_done_successfully'),__('common.success'));
            LogActivity::successLog('blog tag deleted.');
            return redirect()->route('blog.tags.index');
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }
}
