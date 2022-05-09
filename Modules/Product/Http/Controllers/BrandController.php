<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Http\Requests\BrandFormRequest;
use Modules\Product\Services\BrandService;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Product\Http\Requests\UpdateBrandRequest;
use Illuminate\Support\Facades\DB;
use Modules\UserActivityLog\Traits\LogActivity;

class BrandController extends Controller
{

    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->middleware('maintenance_mode');
        $this->brandService = $brandService;
    }

    public function index(Request $request)
    {
        if ($request->input('keyword') != null) {
            $data['brands'] = $this->brandService->getBySearch($request->input('keyword'));
            $data['keyword'] = $request->input('keyword');
        }else {
            $data['brands'] = $this->brandService->getByPaginate(10);
        }
        $data['total_brands'] = $this->brandService->getAll()->count();
        return view('product::brand.index', $data);
    }

    public function bulk_brand_upload_page()
    {
        return view('product::brand.bulk_upload');
    }

    public function csv_brand_download()
    {
        try {
            $this->brandService->csvDownloadBrand();
            $filePath = storage_path("app/brand_list.xlsx");
        	$headers = ['Content-Type: text/csv'];
        	$fileName = time().'-brand_list.xlsx';

        	return response()->download($filePath, $fileName, $headers);
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'));
            return back();
        }
    }

    public function bulk_brand_store (Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx|max:2048'
        ]);
        ini_set('max_execution_time', 0);
        DB::beginTransaction();
        try {
            $this->brandService->csvUploadBrand($request->except("_token"));
            DB::commit();
            LogActivity::successLog('Bulk brand store successful.');
            Toastr::success(__('common.uploaded_successfully'),__('common.success'));
            return back();

        } catch (\Exception $e) {
            DB::rollBack();
            if ($e->getCode() == 23000) {
                Toastr::error(__('common.duplicate_entry_is_exist_in_your_file'));
            }
            else {
                Toastr::error(__('common.Something Went Wrong'));
            }
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }


    public function create(Request $request)
    {
        try{
            return view('product::brand.create');
        }catch(\Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return redirect()->back();
        }

    }


    public function store(BrandFormRequest $request)
    {

        try {
            $this->brandService->save($request->except("_token"));
            Toastr::success(__('common.created_successfully'),__('common.success'));
            LogActivity::successLog('Brand Added.');

            if(isset($request->form_type)){
                if($request->form_type == 'modal_form'){
                    $brands = $this->brandService->getActiveAll();
                    return view('product::products.components._brand_list_select',compact('brands'));
                }else{
                    return redirect()->route('product.brands.index');
                }
            }else{
                return redirect()->route('product.brands.index');
            }
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }


    public function show($id)
    {
        return view('product::show');
    }


    public function edit($id)
    {
        try {
            $data['brand'] = $this->brandService->findById($id);
            return view('product::brand.edit', $data);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }


    public function update(UpdateBrandRequest $request, $id)
    {
        try {
            $this->brandService->update($request->except("_token"), $id);
            Toastr::success(__('common.updated_successfully'),__('common.success'));
            LogActivity::successLog('Brand updated.');
            return redirect()->route('product.brands.index');
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }


    public function destroy($id)
    {
        try {
            $result = $this->brandService->deleteById($id);
            if ($result == "not_possible") {
                 Toastr::warning(__('product.related_data_exist_in_multiple_directory'),__('com◘mon.warning'));
            }
            else {
                LogActivity::successLog('Brand Deleted.');
               Toastr::success(__('common.deleted_successfully'),__('common.success'));
            }
            return redirect()->route('product.brands.index');
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }

    public function update_status(Request $request)
    {
        try {
            $brand = $this->brandService->findById($request->id);
            $brand->status = $request->status;
            $brand->save();
            LogActivity::successLog('brand status update successful.');
            return 1;
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return 0;
        }
    }

    public function update_feature(Request $request)
    {
        try {
            $brand = $this->brandService->findById($request->id);
            $brand->featured = $request->featured;
            $brand->save();
            LogActivity::successLog('feature status update successful.');
            return 1;
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return 0;
        }
    }

    public function updateOrder(Request $request)
    {
        if($request->has('ids')){
            $arr = explode(',',$request->input('ids'));

            foreach($arr as $sortOrder => $id){
                $menu = $this->brandService->findById($id);
                $menu->sort_id = $sortOrder;
                $menu->save();
            }

            LogActivity::successLog('order status update successful.');
            return ['success'=>true,'message'=>'Updated'];
        }
    }

    public function sortableUpdate(Request $request)
    {
        $posts = $this->brandService->getAll();

        foreach ($posts as $post) {
            foreach ($request->order as $order) {
                if ($order['id'] == $post->id) {
                    $post->update(['sort_id' => $order['position']]);
                }
            }
        }

        LogActivity::successLog('sortable update successful.');

        return response('Update Successfully.', 200);
    }

    public function load_more_brands(Request $request)
    {
        $skip = $request->skip ?? 0;

        $brands = $this->brandService->getBySkipTake($skip, 10);
        $output = '';
        if (count($brands) > 0) {
            $output = (string)view('product::brand.list',['brands' => $brands]);
        }
        return \response()->json([
            'brands' => $output
        ]);

    }
}
