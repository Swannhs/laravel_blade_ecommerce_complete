<?php

namespace Modules\GeneralSetting\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use \Modules\GeneralSetting\Services\CurrencyService;
use Modules\UserActivityLog\Traits\LogActivity;

class CurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->middleware('maintenance_mode');
        $this->currencyService = $currencyService;
    }

    public function index()
    {
        
        try{
            $currencies = $this->currencyService->getAll();
            return view('generalsetting::currencies.index', [
                "currencies" => $currencies
            ]);
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }

    }

    public function store(Request $request)
    {
        $request->validate([
              "name" => "required",
              "code" => "required",
              "symbol" => "required"
        ]);

        try {
            $this->currencyService->create($request->except("_token"));
            LogActivity::successLog('Currency Added Successfully');
            Toastr::success(__('common.added_successfully'), __('common.success'));
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
              "name" => "required",
              "code" => "required",
              "symbol" => "required"
        ]);

        try {
            $currency = $this->currencyService->update($request->except("_token"), $id);
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('Currency updated Successfully');
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $currency = $this->currencyService->delete($id);
            Toastr::success(__('common.deleted_successfully'), __('common.success'));
            LogActivity::successLog('Currency deleted Successfully');
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function edit_modal(Request $request)
    {
        try {
            $currency = $this->currencyService->findById($request->id);
            return view('generalsetting::currencies.edit_modal', [
                "currency" => $currency
            ]);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return $e->getMessage();
        }
    }

    public function update_active_status(Request $request){
        try{
            if($request->id != app('general_setting')->currency){
                $currency = $this->currencyService->findById($request->id);
                $currency->status = $request->status;
                if($currency->save()){
                    LogActivity::successLog('Currency status active Successfully');
                    return response()->json([
                        'msg' => 'success'
                    ],200);
                }
            }else{
                return response()->json([
                    'msg' => 'default_currency'
                ],200);
            }
            
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return response()->json([
                'msg' => 'error'
            ],503);
        }
    }
}
