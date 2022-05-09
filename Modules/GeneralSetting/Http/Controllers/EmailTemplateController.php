<?php

namespace Modules\GeneralSetting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Modules\GeneralSetting\Entities\Currency;
use \Modules\GeneralSetting\Services\EmailTemplateService;
use Modules\OrderManage\Repositories\DeliveryProcessRepository;
use Modules\Refund\Repositories\RefundProcessRepository;
use Modules\GeneralSetting\Http\Requests\EmailTemplateRequest;
use App\Traits\SendMail;
use Modules\UserActivityLog\Traits\LogActivity;

class EmailTemplateController extends Controller
{
    use SendMail;
    protected $emailTemplateService;

    public function __construct(EmailTemplateService $emailTemplateService)
    {
        $this->middleware('maintenance_mode');
        $this->emailTemplateService = $emailTemplateService;
    }

    public function index()
    {
        $data['email_templates'] = $this->emailTemplateService->getEmailTemplates();
        return view('generalsetting::email_templates.index', $data);
    }


    public function create()
    {
        $data['email_template_types'] = $this->emailTemplateService->getEmailTemplateTypes();
        $orderDeliveryRepo = new DeliveryProcessRepository;
        $data['delivery_processes'] = $orderDeliveryRepo->getAll();
        $refundProcessRepo = new RefundProcessRepository;
        $data['refund_processes'] = $refundProcessRepo->getAll();
        return view('generalsetting::email_templates.create', $data);
    }


    public function store(EmailTemplateRequest $request)
    {
        try {
            if ($request->reciepnt_type == null) {

            Toastr::error(__('general_settings.please_select_valid_reciepent_to_create_template'));

                return back();
            }
            $this->emailTemplateService->createTemplate($request->except('_token'));
            Toastr::success(__('common.created_successfully'),__('common.success'));
            LogActivity::successLog('Email Templete create successful.');
            return redirect(route('email_templates.index'));
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'));
            return back();
        }

    }


    public function show($id)
    {
        try {
            $data['email_template'] = $this->emailTemplateService->find($id);
            return view('generalsetting::email_templates.edit', $data);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'));
            return back();
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $this->emailTemplateService->updateEmailTemplate($request->except('_token'), $id);
            Toastr::success(__('common.updated_successfully'),__('common.success'));
            LogActivity::successLog('Email Templete update successful.');
            return redirect(route('email_templates.index'));
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'));
            return back();
        }
    }

    public function update_status(Request $request)
    {
        try {
            $result = $this->emailTemplateService->updateEmailTemplateStatus($request->except('_token'));
            if($result == 1){
                LogActivity::successLog('Email Templete status update successful.');
            }
            return $this->reload_with_data($result);
            
            
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return 0;
        }
    }
    

    public function test_mail_send(Request $request)
    {

        try {
            $mail =  $this->sendMailTest($request->email, "Test Mail", $request->content);

            if($mail == true)
            {
                Toastr::success(__('general_settings.Mail has been sent Successfully'));
                return back();
            }
                Toastr::success(__('general_settings.Please Configure SMTP settings first'));

            return back();
        }catch(\Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'));
            return redirect()->back();
        }
    }

    private function reload_with_data($result){
        $email_templates = $this->emailTemplateService->getEmailTemplates();
        return response()->json([
            'msg' => $result,
            'list' => (string)view('generalsetting::email_templates.components.list', compact('email_templates'))
        ]);
    }
}
