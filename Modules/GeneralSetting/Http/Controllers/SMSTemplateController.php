<?php

namespace Modules\GeneralSetting\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GeneralSetting\Services\SmsTemplateService;
use Modules\OrderManage\Repositories\DeliveryProcessRepository;
use Modules\Refund\Repositories\RefundProcessRepository;
use Modules\UserActivityLog\Traits\LogActivity;

class SMSTemplateController extends Controller
{
    protected $sms_template_service;
    public function __construct(SmsTemplateService $sms_template_service)
    {
        $this->middleware('maintenance_mode');
        $this->sms_template_service = $sms_template_service;
    }

    public function index(){
        $sms_templates = $this->sms_template_service->getSmsTemplates();
        return view('generalsetting::sms_templates.index', compact('sms_templates'));
    }

    public function create(){
        $data['sms_template_types'] = $this->sms_template_service->getSmsTemplateTypes();
        $orderDeliveryRepo = new DeliveryProcessRepository;
        $data['delivery_processes'] = $orderDeliveryRepo->getAll();
        $refundProcessRepo = new RefundProcessRepository;
        $data['refund_processes'] = $refundProcessRepo->getAll();
        return view('generalsetting::sms_templates.create', $data);
    }

    public function store(Request $request){
        try {
            if ($request->reciepnt_type == null) {

            Toastr::error(__('general_settings.please_select_valid_reciepent_to_create_template'));

                return back();
            }
            $this->sms_template_service->createTemplate($request->except('_token'));
            Toastr::success(__('common.created_successfully'),__('common.success'));
            LogActivity::successLog('SMS Templete create successful.');
            return redirect(route('sms_templates.index'));
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'));
            return back();
        }
    }

    public function edit($id){
        try {
            $sms_template = $this->sms_template_service->find($id);
            return view('generalsetting::sms_templates.edit', compact('sms_template'));
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'));
            return back();
        }
    }

    public function update(Request $request, $id){
        try {
            $this->sms_template_service->updateSmsTemplate($request->except('_token'), $id);
            Toastr::success(__('common.updated_successfully'),__('common.success'));
            LogActivity::successLog('SMS Templete update successful.');
            return redirect(route('sms_templates.index'));
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'));
            return back();
        }
    }

    public function update_status(Request $request){
        try {
            $result = $this->sms_template_service->updateSmsTemplateStatus($request->except('_token'));
            if($result == 1){
                LogActivity::successLog('SMS Templete status update successful.');
            }
            return $this->reload_with_data($result);
            
            
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return 0;
        }
    }

    private function reload_with_data($result){
        $sms_templates = $this->sms_template_service->getSmsTemplates();
        return response()->json([
            'msg' => $result,
            'list' => (string)view('generalsetting::sms_templates.components.list', compact('sms_templates'))
        ]);
    }
    
}
