<?php

namespace Modules\GeneralSetting\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use App\Traits\ImageStore;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Modules\GeneralSetting\Entities\Currency;
use \Modules\GeneralSetting\Services\GeneralSettingService;
use App\Traits\SendSMS;
use App\Traits\SendMail;
use Illuminate\Support\Facades\Artisan;
use Modules\Setup\Repositories\CityRepository;
use Modules\Setup\Repositories\CountryRepository;
use Modules\Setup\Repositories\StateRepository;
use Modules\UserActivityLog\Traits\LogActivity;

class GeneralSettingController extends Controller
{
    use ImageStore, SendSMS, SendMail;
    protected $generalSettingService;

    public function __construct(GeneralSettingService $generalSettingService)
    {
        $this->middleware('maintenance_mode');
        $this->generalSettingService = $generalSettingService;
    }

    public function index()
    {
        $data['others_activations'] = $this->generalSettingService->getVerificationNotification();
        $data['vendor_configurations'] = $this->generalSettingService->getVendorConfigurationAll();
        $data['sms_gateways'] = $this->generalSettingService->getSmsGateways();
        $data['setting'] = $this->generalSettingService->getGeneralInfo();
        $data['languages'] = $this->generalSettingService->getLanguages();
        $data['dateformats'] = $this->generalSettingService->getDateFormats();
        $data['timezones'] = $this->generalSettingService->getTimezones();
        $data['countries'] = (new CountryRepository())->getActiveAll();
        $data['states'] = (new StateRepository())->getByCountryId($data['setting']->default_country);
        return view('generalsetting::index', $data);
    }

    public function activation_index()
    {
        $data['others_activations'] = $this->generalSettingService->getVerificationNotification();
        $data['vendor_configurations'] = $this->generalSettingService->getVendorConfigurationAll();
        $data['sms_gateways'] = $this->generalSettingService->getSmsGateways();
        $data['setting'] = $this->generalSettingService->getGeneralInfo();
        $data['languages'] = $this->generalSettingService->getLanguages();
        $data['dateformats'] = $this->generalSettingService->getDateFormats();
        $data['timezones'] = $this->generalSettingService->getTimezones();
        return view('generalsetting::activation_index', $data);
    }

    public function sms_index()
    {
        $data['others_activations'] = $this->generalSettingService->getVerificationNotification();
        $data['vendor_configurations'] = $this->generalSettingService->getVendorConfigurationAll();
        $data['sms_gateways'] = $this->generalSettingService->getSmsGateways();
        $data['setting'] = $this->generalSettingService->getGeneralInfo();
        $data['languages'] = $this->generalSettingService->getLanguages();
        $data['dateformats'] = $this->generalSettingService->getDateFormats();
        $data['timezones'] = $this->generalSettingService->getTimezones();
        return view('generalsetting::sms_index', $data);
    }

    public function smtp_index()
    {
        $data['others_activations'] = $this->generalSettingService->getVerificationNotification();
        $data['vendor_configurations'] = $this->generalSettingService->getVendorConfigurationAll();
        $data['sms_gateways'] = $this->generalSettingService->getSmsGateways();
        $data['setting'] = $this->generalSettingService->getGeneralInfo();
        $data['languages'] = $this->generalSettingService->getLanguages();
        $data['dateformats'] = $this->generalSettingService->getDateFormats();
        $data['timezones'] = $this->generalSettingService->getTimezones();
        return view('generalsetting::smtp_index', $data);
    }

    public function company_index()
    {
        $data['others_activations'] = $this->generalSettingService->getVerificationNotification();
        $data['vendor_configurations'] = $this->generalSettingService->getVendorConfigurationAll();
        $data['sms_gateways'] = $this->generalSettingService->getSmsGateways();
        $data['setting'] = $this->generalSettingService->getGeneralInfo();
        $data['languages'] = $this->generalSettingService->getLanguages();
        $data['dateformats'] = $this->generalSettingService->getDateFormats();
        $data['timezones'] = $this->generalSettingService->getTimezones();
        $data['countries'] = (new CountryRepository())->getActiveAll();
        $data['states'] = (new StateRepository())->getByCountryId($data['setting']->country_id);
        $data['cities'] = (new CityRepository())->getByStateId($data['setting']->state_id);
        return view('generalsetting::company_index', $data);
    }


    public function update(Request $request)
    {
        if ($request->has('status')) {
            $request->validate([
                "site_title" => "required|string|max:30",
                "file_supported" => "nullable|string",
                "copyright_text" => "nullable|string",
                "language_id" => "nullable",
                "date_format" => "required",
                "currency_id" => "required",
                "time_zone" => "nullable",
                "preloader" => "required",
                "country_id" => "required",
                "state_id" => "required",
                "city_id" => "required",
                "invoice_prefix" => "nullable",
                "agent_commission_type" => "nullable",
                "sale_margin_price" => "nullable",
                "site_logo" => "nullable|mimes:jpg,png,jpeg",
                "favicon_logo" => "nullable|mimes:jpg,png,jpeg",
                "shop_link_banner" => "nullable|mimes:jpg,png,jpeg"
            ]);
        } else {
        }

        if ($request->favicon_logo != null) {
            $url = $this->saveSettingsImage($request->favicon_logo,50,50);
            $this->deleteImage(app('general_setting')->favicon);
            $this->savePWAIcon($request->favicon_logo);
            $request->merge(["favicon" => $url]);
        }
        if ($request->site_logo != null) {
            $url = $this->saveSettingsImage($request->site_logo,50, 193);
            $this->deleteImage(app('general_setting')->logo);
            $this->savePWASplash($request->site_logo);
            $request->merge(["logo" => $url]);
        }
        $shopLinkUrl = app('general_setting')->shop_link_banner;
        if ($request->shop_link_banner != null) {
            $shopLinkUrl = $this->saveSettingsImage($request->shop_link_banner,350,1920);
            $request->merge(["shop_link_banner" => $shopLinkUrl]);
        }
        if ($request->currency_id != null) {
            
            $currency = Currency::findOrFail($request->currency_id);
            $request->merge(["currency" => $currency->id, "currency_symbol" => $currency->symbol, "currency_code" => $currency->code, "currency_convert_rate" => $currency->convert_rate]);

            $users = User::all();
            foreach($users as $user){
                $user->currency_id = $currency->id;
                $user->currency_code = $currency->code;
                $user->save();
            }
        }
        if($request->time_zone != null){
            setEnv('TIME_ZONE',$request->time_zone);
        }
        if($request->has('decimal_limit')){
            $request->merge(['decimal_limit' => intval(round($request->decimal_limit))]);
        }

        try {
            $this->generalSettingService->update($request->except("_token", "favicon_logo", "site_logo", "shop_link_banner", "currency_id", "status"));
            $this->generalSettingService->updateShopLink($shopLinkUrl);
            Artisan::call('optimize:clear');

            if ($request->has('status')) {
                return back();
            } else {

                LogActivity::successLog('Updated Successfully');
                Toastr::success(__('common.updated_successfully'), __('common.success'));
                return back();
            }
        } catch (\Exception $e) {

            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return redirect()->back();
        }
    }



    public function update_activation_status(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        try {
            $this->generalSettingService->update_activation($request->only('id', 'status'));
            LogActivity::successLog('General activation Updated !!!');
            return 1;
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return 0;
        }
    }

    public function sms_gateway_credentials_update(Request $request)
    {
        if($request->input('action') == 'other'){
            $request->validate([
                'url' => 'required',
                'request_method' => 'required',
                'sms_gateway_id' => 'required'
            ]);
        }else{
            $request->validate([
                'sms_gateway_id' => 'required'
            ]);
        }

        try {

            $this->generalSettingService->update_sms_activation($request->except("_token"));
            session()->forget('g_set');
            session()->forget('smtp_set');

            session()->put('sms_set', '1');
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('sms gateway credential update successful.');
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return redirect()->back();
        }
    }

    public function smtp_gateway_credentials_update(Request $request)
    {

        $request->validate([
            'mail_gateway' => 'required'
        ]);
        try {
            $this->generalSettingService->update_smtp_gateway_credentials($request->except("_token"));

            session()->forget('g_set');
            session()->forget('sms_set');

            session()->put('smtp_set', '1');
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('SMTP gateway credential successful.');
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return redirect()->back();
        }
    }

    public function test_mail_send(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'content' => 'required'
        ]);

        try {
            $mail =  $this->sendMailTest($request->email, "Test Mail", $request->content);

            if ($mail === true) {
                LogActivity::successLog('mail sent successful.');
                Toastr::success(__('general_settings.mail_has_been_sent_successfully'), __('common.success'));
                return back();
            }elseif($mail === 'failed'){
                Toastr::error(__('common.please_configure_mail_settings_first'), __('common.success'));
            }else{
                Toastr::error(__('common.Something Went Wrong'));
            }

            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return redirect()->back();
        }
    }

    public function sms_send_demo(Request $request)
    {
        $request->validate([
            'number' => 'required',
            'message' => 'required'
        ]);
        try {
            $response = $this->sendSMS($request->number, $request->message);
            if($response){
                Toastr::success(__('common.sms_has_been_sent_successfully'), __('common.success'));
                LogActivity::successLog('sms send successful.');
            }
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function emailTemplate(Request $request)
    {
        try {
            $this->generalSettingService->updateEmailTemplate($request->except('_token'));
            session()->forget('g_set');
            session()->forget('smtp_set');
            session()->forget('sms_set');
            Toastr::success(__('common.updated_successfully'),__('common.success'));
            LogActivity::successLog('email templete update successful.');
            return back();
        } catch (\Exception $e) {

            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return redirect()->back();
        }
    }

    public function import()
    {
        $sql_path = base_path('static_sql/custom.sql');
        DB::unprepared(file_get_contents($sql_path));
    }

    public function footer_update(Request $request)
    {
        try {
            $this->generalSettingService->updateEmailFooterTemplate($request->except('_token'));

            session()->forget('g_set');
            session()->forget('smtp_set');
            session()->forget('sms_set');

            Toastr::success(__('setting.Email Footer has been updated Successfully'));
            LogActivity::successLog('footer update successful.');
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return redirect()->back();
        }
    }



}
