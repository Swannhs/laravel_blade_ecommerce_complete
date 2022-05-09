<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Services\BlogCategoryService;
use Modules\Blog\Entities\BlogCategory;
use Modules\Blog\Entities\BlogPost;
use App\Traits\ImageStore;
use Brian2694\Toastr\Facades\Toastr;
use Modules\UserActivityLog\Traits\LogActivity;

class BlogCategoryController extends Controller
{

    use ImageStore;
    protected $blogCategoryService;

    public function __construct(BlogCategoryService $blogCategoryService)
    {
        $this->blogCategoryService = $blogCategoryService;
        $this->middleware('maintenance_mode');
        $this->middleware('prohibited_demo_mode')->only('store','update','destroy');
    }

    public function index()
    {
        try{

            $data['itemCategories']  = $this->blogCategoryService->getAll();

            return view('blog::category.category',$data);
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }




    public function store(Request $request)
    {

        $request->validate([
                'name' => 'required|string|unique:blog_categories,name',
                'file.*' => 'required|mimes:jpg,jpeg,bmp,png'
            ]);

         try{

            $file = $request->file('file');
            if($request->hasFile('file'))
            {
                $filename=$this->saveImage($file,64,64);
            }
            $parent_id=0;
            $level=1;
            if(!empty($request['parent_id'])){
              $parent_id=$request['parent_id'];
              $level_check=BlogCategory::where('id',$parent_id)->first();
              $level=$level_check->level+1;
            }

            $this->blogCategoryService->create([
                'name' => $request['name'],
                'parent_id' => $parent_id,
                'level' => $level,
                'image_url' => isset($filename)?$filename:null
            ]);
            Toastr::success(__('common.operation_done_successfully'),__('common.success'));
            LogActivity::successLog('blog category added');
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

            $data['itemCategories']  = $this->blogCategoryService->getAll();
            $data['editData']   = $this->blogCategoryService->find($id);
            return view('blog::category.category',$data);
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
                'name' => 'required|string|unique:blog_categories,name,'.$id
            ]);
        try{
            $data['name']=$request['name'];
            if(!empty($request['parent_id'])){
                $data['parent_id']=$request['parent_id'];
                $level_check=BlogCategory::where('id',$data['parent_id'])->first();
                $data['level']=$level_check->level+1;
            }
            if (!empty($request->hasFile('file'))) {
                $category=BlogCategory::where('id',$id)->first();
                if($category->image_url){
                    unlink(public_path($category->image_url));
                }
                $file = $request->file('file');
                $filename=$filename=$this->saveImage($file,64,64);
                $data['image_url']=$filename;
            }

            $this->blogCategoryService->update($data,$id);
            Toastr::success(__('common.operation_done_successfully'),__('common.success'));

            LogActivity::successLog('blog category updated');
            return redirect()->route('blog.categories.index');
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }


    public function destroy($id)
    {
        try{
            $this->blogCategoryService->delete($id);
            Toastr::success(__('common.operation_done_successfully'),__('common.success'));
            LogActivity::successLog('blog category deleted.');
            return redirect()->route('blog.categories.index');
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return $e->getMessage().$e->getLine();
            return redirect()->route('blog.categories.index');
        }
    }
}
