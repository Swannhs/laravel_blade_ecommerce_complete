<?php

namespace Modules\Seller\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Seller\Services\SupplierService;
use Modules\Setup\Entities\Country;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Seller\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    protected $supplierService;
    public function __construct(SupplierService $supplierService)
    {
        $this->middleware('maintenance_mode');
        $this->supplierService = $supplierService;
    }

    public function index()
    {
        $suppliers = $this->supplierService->getAll();
        return view('seller::supplier.index',compact('suppliers'));
    }


    public function create()
    {
        $countries = Country::all();
        return view('seller::supplier.components.create',compact('countries'));
    }


    public function store(SupplierRequest $request)
    {

        $this->supplierService->store($request->except('_token'));

        \LogActivity::successLog('supplier added');
        Toastr::success(__('common.created_successfully'),__('common.success'));
        return redirect()->route('seller.supplier.index');
    }


    public function show($id)
    {
        $supplier = $this->supplierService->editByID($id);
        return view('seller::supplier.components.view',compact('supplier'));
    }


    public function edit($id)
    {
        $supplier = $this->supplierService->editByID($id);
        $countries = Country::all();
        return view('seller::supplier.components.edit',compact('supplier','countries'));
    }


    public function update(SupplierRequest $request, $id)
    {

        $this->supplierService->update($request->except('_token'),$id);

        \LogActivity::successLog('supplier updated');
        Toastr::success(__('common.updated_successfully'),__('common.success'));
        return redirect()->route('seller.supplier.index');
    }


    public function destroy(Request $request)
    {
        $this->supplierService->deleteByID($request->id);
        \LogActivity::successLog('Supplier deleted.');
        return $this->loadTableData();
    }

    public function statusChange(Request $request){

        $this->supplierService->statusChange($request->except('_token'));
        \LogActivity::successLog('supplier status changed');
        return $this->loadTableData();
    }

    private function loadTableData()
    {

        try {
            $suppliers = $this->supplierService->getAll();

            return response()->json([
                'SupplierList' =>  (string)view('seller::supplier.components.list', compact('suppliers')),
            ]);
        } catch (\Exception $e) {
            \LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }
}
