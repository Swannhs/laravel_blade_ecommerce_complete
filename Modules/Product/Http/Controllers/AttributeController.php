<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Services\AttributeService;
use Modules\Product\Http\Requests\AttributeFormRequest;
use Brian2694\Toastr\Facades\Toastr;
use Modules\UserActivityLog\Traits\LogActivity;

class AttributeController extends Controller
{
    protected $attributeService;

    public function __construct(AttributeService $attributeService)
    {
        $this->middleware('maintenance_mode');
        $this->attributeService = $attributeService;
    }

    public function index()
    {
        $data['attributes'] = $this->attributeService->getAll();
        return view('product::attributes.index', $data);
    }

    public function get_list()
    {
        $data['attributes'] = $this->attributeService->getAll();
        return view('product::attributes.attributes_list', $data);
    }

    public function store(AttributeFormRequest $request)
    {
        try {
            $this->attributeService->save($request->except("_token"));
            LogActivity::successLog('Attribute Added.');

            if (isset($request->form_type)) {
                if ($request->form_type == 'modal_form') {
                    $attributes = $this->attributeService->getActiveAll();
                    return view('product::products.components._attribute_list_select', compact('attributes'));
                } else {
                    return response()->json(["message" => "Attribute Added Successfully"], 200);
                }
            } else {
                return response()->json(["message" => "Attribute Added Successfully"], 200);
            }
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }
    }

    public function show(Request $request)
    {

        try {
            $atribute = $this->attributeService->findById($request->id);

            $values = [];
            foreach ($atribute->values as $key => $value) {
                array_push($values, $value->value);
            }

            return view('product::attributes.show', [
                "atribute" => $atribute,
                'values' => $values
            ]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }
    }

    public function edit($id)
    {
        try {
            $attribute = $this->attributeService->findById($id);
            return view('product::attributes.edit_attribute',compact('attribute'));
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }
    }

    public function update(AttributeFormRequest $request, $id)
    {
        try {
            $this->attributeService->update($request->except("_token"), $id);
            LogActivity::successLog('Attribute Updated.');
            return response()->json([
                "message" => "Attribute Updated Successfully",
                "createForm" => (string)view('product::attributes.create_attribute')
            ], 200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }
    }

    public function destroy($id)
    {
        try {
            if($id == 1){
                Toastr::warning(__('product.color_attribute_is_not_deletable'));
                return back();
            }
            $result = $this->attributeService->deleteById($id);
            if ($result == "not_possible") {
                Toastr::warning(__('product.related_data_exist_in_multiple_directory'));
                return back();
            } else {
                LogActivity::successLog('Attribute Deleted.');
                Toastr::success(__('common.deleted_successfully'), __('common.success'));
                return redirect()->route('product.attribute.index');
            }
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }

    public function attribute_values(Request $request)
    {

        try {
            $attribute = $request->id;
            return view('product::products.selected_attributes', compact('attribute'));
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong", "error" => $e->getMessage()], 503);
        }
    }
}
