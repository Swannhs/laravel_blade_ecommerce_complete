<?php

namespace Modules\Setup\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Setup\Services\TagService;
use Modules\UserActivityLog\Traits\LogActivity;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->middleware('maintenance_mode');
        $this->tagService = $tagService;
    }

    public function index(Request $request)
    {
        try{
            $tags = $this->tagService->getAll();
            return view('setup::tags.index', [
                "tags" => $tags,
            ]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }

    public function get_list()
    {
        $data['tags'] = $this->tagService->getAll();
        return view('setup::tags.tags_list', $data);
    }

    public function get_data(){

        $value = $this->tagService->getAll();

        return DataTables::of($value)
            ->addIndexColumn()
            ->addColumn('name', function($value){
                return Str::limit($value->name,15);
            })
            ->addColumn('action', function($value){
                return view('setup::tags._action_td',compact('value'));
            })
            ->rawColumns(['action'])
            ->toJson();
    }


    public function store(Request $request)
    {
        try {
            $this->tagService->save($request->except("_token"));
            LogActivity::successLog('tag store successful.');
            return response()->json(["message" => "Tags Added Successfully"], 200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->tagService->update($request->except("_token"), $id);
            LogActivity::successLog('tag update successful.');
            return response()->json(["message" => "Tags Added Successfully"], 200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }
    }

    public function destroy($id)
    {
        try {
            $this->tagService->delete($id);
            LogActivity::successLog('A Tag has been destroyed.');
            Toastr::success(__('common.deleted_successfully'),__('common.success'));
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage().' - Error has been detected for Tag Destroy');
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }

    public function getTagBySentence(Request $request)
    {
        return $this->tagService->getTagBySentence($request->sentence);
    }
}
