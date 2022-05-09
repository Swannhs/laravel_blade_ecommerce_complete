<?php

namespace Modules\Product\Http\Controllers;

use App\Traits\Notification;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use \Modules\Product\Services\CategoryService;
use Modules\Product\Services\AttributeService;
use Modules\Product\Services\UnitTypeService;
use Modules\Product\Services\ProductService;
use Modules\Product\Services\BrandService;
use Modules\Setup\Services\TagService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Modules\GeneralSetting\Entities\EmailTemplateType;
use Modules\Product\Entities\Product;
use Modules\Shipping\Services\ShippingService;
use Modules\Product\Http\Requests\CreateProductRequest;
use Modules\Seller\Entities\SellerProduct;
use Yajra\DataTables\Facades\DataTables;
use Modules\UserActivityLog\Traits\LogActivity;

class ProductController extends Controller
{
    use Notification;
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->middleware('maintenance_mode');
        $this->productService = $productService;
    }

    public function index()
    {
        $data['products'] = $this->productService->all();
        $data['productRequests'] = $this->productService->getRequestProduct();
        $data['product_skus'] = $this->productService->getAllSKU();
        return view('product::products.index', $data);
    }

    public function bulk_product_upload_page()
    {
        return view('product::products.bulk_upload');
    }

    public function bulk_product_store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx|max:2048'
        ]);
        ini_set('max_execution_time', 0);
        DB::beginTransaction();
        try {
            $this->productService->csvUploadCategory($request->except("_token"));
            DB::commit();
            Toastr::success(__('common.uploaded_successfully'), __('common.success'));
            LogActivity::successLog('bulk product upload successful.');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e->getCode() == 23000) {
                Toastr::error(__('common.duplicate_entry_is_exist_in_your_file'));
            } else {
                Toastr::error(__('common.error_message'));
            }
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }

    public function related_product(Request $request)
    {

        if ($request->ajax()) {

            $data['products'] = $this->productService->allbyPaginate()->where('id', '!=', $request->except_id);

            return view('product::products.components._related_product', $data);
        }
    }

    public function crosssale_product(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('except_id')) {
                $data['products'] = $this->productService->allbyPaginate()->where('id', '!=', $request->except_id);
            } else {
                $data['products'] = $this->productService->allbyPaginate();
            }

            return view('product::products.components._crosssale_product', $data);
        }
    }

    public function upsale_product(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('except_id')) {
                $data['products'] = $this->productService->allbyPaginate()->where('id', '!=', $request->except);
            } else {
                $data['products'] = $this->productService->allbyPaginate();
            }

            return view('product::products.components._upsale_product', $data);
        }
    }

    public function getData()
    {
        $user = auth()->user();
        $status_slider = '_all_product_';
        if(isset($_GET['table'])){
            $products = $this->productService->getFilterdProduct($_GET['table']);
            $status_slider = '_'.$_GET['table'].'_';
        }else{
            if($user->role->type == 'seller'){
                $products = $this->productService->getSellerProduct();
            }else{
                $products = $this->productService->getProduct();
            }
            
        }

        $type = $user->role->type;
        return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('product_type', function ($products) {
                return view('product::products.components._product_type_td', compact('products'));
            })
            ->addColumn('brand', function ($products) {
                return @$products->brand->name ?? '';
            })
            ->addColumn('logo', function ($products) {
                return view('product::products.components._product_logo_td', compact('products'));
            })
            ->addColumn('status', function ($products) use ($type,$status_slider) {
                return view('product::products.components._product_status_td', compact('products', 'type', 'status_slider'));
            })
            ->addColumn('action', function ($products) use ($type) {
                return view('product::products.components._product_action_td', compact('products', 'type'));
            })
            ->addColumn('stock', function ($products) use ($type) {
                return view('product::products.components._product_stock_td', compact('products'));
            })
            ->rawColumns(['product_type', 'logo', 'status', 'action','stock'])
            ->toJson();
    }

    public function requestGetData()
    {
        $products = $this->productService->getRequestProduct();

        return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('product_type', function ($products) {
                return view('product::products.components._product_type_td', compact('products'));
            })
            ->addColumn('brand', function ($products) {
                return @$products->brand->name;
            })
            ->addColumn('logo', function ($products) {
                return view('product::products.components._product_logo_td', compact('products'));
            })
            ->addColumn('seller', function ($products) {
                return @$products->seller->first_name;
            })
            ->addColumn('approval', function ($products) {
                return view('product::products.components._request_product_approval_td', compact('products'));
            })
            ->addColumn('action', function ($products) {
                return view('product::products.components._request_product_action_td', compact('products'));
            })
            ->rawColumns(['product_type', 'logo', 'status', 'action'])
            ->toJson();
    }

    public function skuGetData()
    {
        $skus = $this->productService->getAllSKU();
        return DataTables::of($skus)
            ->addIndexColumn()
            ->addColumn('product', function ($skus) {
                return @$skus->product->product_name;
            })
            ->addColumn('brand', function ($skus) {
                return @$skus->product->brand->name;
            })
            ->addColumn('purchase_price', function ($skus) {

                return '<p class="text-nowrap">' . @$skus->sku . '</p>';
            })
            ->addColumn('selling_price', function ($skus) {

                return single_price(@$skus->selling_price);
            })
            ->addColumn('logo', function ($skus) {
                return view('product::products.components._sku_logo_td', compact('skus'));
            })

            ->addColumn('action', function ($skus) {
                return view('product::products.components._sku_action_td', compact('skus'));
            })
            ->rawColumns(['product_type', 'logo', 'status', 'action', 'purchase_price'])
            ->toJson();
    }


    public function create(CategoryService $categoryService, UnitTypeService $unitTypeService, BrandService $brandService, TagService $tagService, AttributeService $attributeService, ShippingService $shippingService)
    {
         $data['categories'] = $categoryService->getAll();
        $data['brands'] = $brandService->getActiveAll();
        $data['units'] = $unitTypeService->getActiveAll();
        $data['tags'] = $tagService->getAll();
        $data['attributes'] = $attributeService->getActiveAll();
        $data['products'] = $this->productService->allbyPaginate();
        $data['shippings'] = $shippingService->getActiveAll()->where('id', '!=', 1);
        return view('product::products.create', $data);
    }


    public function store(CreateProductRequest $request)
    {
        DB::beginTransaction();

        try {
            $this->productService->create($request->except("_token"));
            DB::commit();
            Toastr::success(__('common.added_successfully'), __('common.success'));
            LogActivity::successLog('product upload successful.');
            $user = auth()->user();
            if ($request->request_from == 'main_product_form') {
                return redirect()->route('product.index');
            } elseif ($request->request_from == 'seller_product_form') {
                return redirect()->route('seller.product.index');
            } elseif ($request->request_from == 'inhouse_product_form') {
                return redirect()->route('admin.my-product.index');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'));
            return back();
        }
    }


    public function show(Request $request)
    {
        
        $data['product'] = $this->productService->findById($request->id);
        return view('product::products.product_detail', $data);
    }


    public function edit($id, CategoryService $categoryService, UnitTypeService $unitTypeService, BrandService $brandService, TagService $tagService, AttributeService $attributeService, ShippingService $shippingService)
    {
        try {
            $data['product'] = $this->productService->findById($id);
            $data['categories'] = $categoryService->getAll();
            $data['brands'] = $brandService->getActiveAll();
            $data['units'] = $unitTypeService->getActiveAll();
            $data['tags'] = $tagService->getAll();
            $data['attributes'] = $attributeService->getActiveAll();
            $data['shippings'] = $shippingService->getActiveAll();
            $data['products'] = $this->productService->getAllForEdit($id);
            return view('product::products.edit', $data);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }

    public function clone($id, CategoryService $categoryService, UnitTypeService $unitTypeService, BrandService $brandService, TagService $tagService, AttributeService $attributeService, ShippingService $shippingService)
    {
        try {
            $data['product'] = $this->productService->findById($id);
            $data['categories'] = $categoryService->getAll();
            $data['brands'] = $brandService->getAll();
            $data['units'] = $unitTypeService->getActiveAll();
            $data['tags'] = $tagService->getAll();
            $data['attributes'] = $attributeService->getActiveAll();
            $data['shippings'] = $shippingService->getActiveAll();
            $data['products'] = $this->productService->all();
            return view('product::products.clone', $data);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }


    public function update(CreateProductRequest $request, $id)
    {
        DB::beginTransaction();
        
        try {
            if(auth()->user()->role->type == 'seller'){
                $product_for_req = $this->productService->findById($id);
                if($product_for_req->is_approved){
                    Toastr::error('Product already Approved. You Dont have Permission To Edit.');
                    return redirect()->route('seller.product.index');
                }
            }
            if(product_attribute_editable($id) === false && $request->new_attribute_added == 1){
                Toastr::error(__('Product Already Used. Atrribute Add Not Posible.'),__('common.error'));
                return back();
            }
            $this->productService->update($request->except("_token"), $id);
            DB::commit();
            LogActivity::successLog('Product updated.');
            Toastr::success(__('common.updated_successfully'), __('common.success'));

            $user = auth()->user();
            if ($user->role->type == 'superadmin' || $user->role->type == 'admin' || $user->role->type == 'staff') {
                return redirect()->route('product.index');
            } else {
                return redirect()->route('seller.product.index');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'));
            return back();
        }
    }


    public function destroy(Request $request)
    {
        try {
            $result = $this->productService->deleteById($request->id);

            if ($result == "not_possible") {
                return response()->json([
                    'msg' => 'Related Data Exist in Multiple Directory.'
                ]);
            } else {
                LogActivity::successLog('Product deleted.');
                Toastr::success(__('common.deleted_successfully'), __('common.success'));
            }
            return $this->loadTableData();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'));
            return back();
        }
    }

    public function metaImgDelete(Request $request)
    {
        try {
            return $this->productService->metaImgDeleteById($request->id);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'));
            return response()->json([
                'error' => $e->getMessage()
            ], 503);
        }
    }

    public function sku_combination(Request $request)
    {
        $options = array();
        $product_name = $request->product_name;
        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $data = array();
                foreach ($request[$name] as $key => $item) {
                    array_push($data, $item);
                }
                array_push($options, $data);
            }
        }
        $attribute = $request->choice_no;
        $combinations = combinations($options);

        return view('product::products.sku_combinations', compact('combinations', 'product_name', 'attribute'));
    }

    public function sku_combination_edit(Request $request)
    {
        $product = $this->productService->findById($request->id);

        $product_name = $product->product_name;
        $options = array();
        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $data = array();
                foreach ($request[$name] as $key => $item) {
                    array_push($data, $item);
                }
                array_push($options, $data);
            }
        }

        $attribute = $request->choice_no;
        $combinations = combinations($options);
        return view('product::products.sku_combinations_edit', compact('combinations', 'product_name', 'product', 'attribute'));
    }

    public function update_status(Request $request)
    {
        try {
            $product = $this->productService->findById($request->id);
            $product->update([
                'status' => $request->status
            ]);
            if (!isModuleActive('MultiVendor')) {
                $product->sellerProducts->where('user_id', 1)->first()->update([
                    'status' => $request->status
                ]);
            }
            foreach ($product->skus as $sku) {
                $product_sku = $this->productService->findProductSkuById($sku->id);
                $product_sku->status = $request->status;
                $product_sku->save();
            }

            // Send Notification
            $this->notificationUrl = route('seller.product.index');
            $this->typeId = EmailTemplateType::where('type', 'product_disable_email_template')->first()->id;

            $sellerProducts = SellerProduct::where('product_id', $product->id)->get();

            foreach ($sellerProducts as $sellerProduct) {
                $this->notificationSend("Product disable", $sellerProduct->user_id);
            }


            LogActivity::successLog('product status update successful.');
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
        return $this->loadTableData();
    }

    public function update_sku_status(Request $request)
    {
        try {
            $product_sku = $this->productService->findProductSkuById($request->id);
            $product_sku->status = $request->status;
            $product_sku->save();

            LogActivity::successLog('Update sku status successful.');
            return 1;
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return 0;
        }
    }

    public function updateSkuStatusByID(Request $request)
    {
        try {
            $product_sku = $this->productService->findProductSkuById($request->id);
            $product_sku->status = $request->status;
            $product_sku->save();

            LogActivity::successLog('Update sku status successful.');
            return $this->loadTableData();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ], 503);
        }
    }

    public function deleteSkuByID(Request $request)
    {
        try {
            $product_sku = $this->productService->findProductSkuById($request->id);
            $product_sku->delete();


            LogActivity::successLog('delete sku  successful.');
            return $this->loadTableData();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ], 503);
        }
    }
    public function updateSkuByID(Request $request)
    {
        $request->validate([
            'selling_price' => 'required'
        ]);

        try {

            $this->productService->updateSkuByID($request->except('_token'));
            LogActivity::successLog('Update sku  successful.');
            return $this->loadTableData();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json([
                'error' => $e->getMessage()
            ], 503);
        }
    }


    public function approved(Request $request)
    {

        try {
            $this->productService->productApproved($request->except('_token'));
            LogActivity::successLog('product approve  successful.');
            return $this->loadTableData();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ], 503);
        }
    }


    private function loadTableData()
    {

        try {
            return response()->json([
                'RequestProductList' =>  (string)view('product::products.request_product_list'),
                'ProductList' =>  (string)view('product::products.product_list'),
                'ProductSKUList' =>  (string)view('product::products.sku_list'),
                'ProductDisabledList' =>  (string)view('product::products.disabled_product_list'),
                'ProductAlertList' =>  (string)view('product::products.alert_product_list'),
            ], 200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return response()->json([
                'error' => 'something gone wrong'
            ], 503);
        }
    }

    public function recent_view_product_config()
    {
        return view('product::recently_views.config');
    }

    public function recent_view_product_config_update(Request $request)
    {
        try {
            $this->productService->updateRecentViewedConfig($request->except('_token'));
            Toastr::success(__('common.updated_successfully'), __('common.success'));

            LogActivity::successLog('Recent view product config update successful.');
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e;
        }
    }

    public function recently_view_product_cronejob()
    {
        try {
            Artisan::call('command:reset_recent_viewed_product');
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }
}
