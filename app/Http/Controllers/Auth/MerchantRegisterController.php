<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyMail;
use App\Models\MerchantDetail;
use App\Models\User;
use App\Traits\ImageStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Modules\FormBuilder\Repositories\FormBuilderRepositories;
use Notification;
use App\Notifications\NewSellerRegistrationNotification;
use \Modules\FrontendCMS\Services\MerchantContentService;
use \Modules\FrontendCMS\Services\BenefitService;
use \Modules\FrontendCMS\Services\WorkingProcessService;
use \Modules\FrontendCMS\Services\FaqService;
use \Modules\FrontendCMS\Services\PricingService;
use \Modules\FrontendCMS\Services\QueryService;
use \Modules\MultiVendor\Repositories\MerchantRepository;
use App\Providers\RouteServiceProvider;
use App\Traits\Notification as TraitsNotification;
use App\Traits\Otp;
use App\Traits\SendMail;
use Illuminate\Http\Response;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Modules\MultiVendor\Entities\SellerAccount;
use Modules\MultiVendor\Entities\SellerSubcription;
use Modules\MultiVendor\Repositories\CommisionRepository;
use Modules\MultiVendor\Entities\SellerBankAccount;
use Modules\MultiVendor\Entities\SellerBusinessInformation;
use Modules\MultiVendor\Entities\SellerReturnAddress;
use Modules\MultiVendor\Entities\SellerWarehouseAddress;
use Modules\FrontendCMS\Entities\Pricing;
use Modules\FrontendCMS\Entities\MerchantContent;
use Modules\GeneralSetting\Entities\EmailTemplateType;
use Modules\GeneralSetting\Entities\GeneralSetting;
use Modules\GeneralSetting\Entities\UserNotificationSetting;
use Modules\SidebarManager\Entities\Sidebar;
use Modules\UserActivityLog\Traits\LogActivity;
use Nwidart\Modules\Facades\Module;
use Str;
use Exception;
use Illuminate\Support\Facades\Session;

class MerchantRegisterController extends Controller
{
    use RegistersUsers, TraitsNotification, SendMail, Otp;
    protected $merchantContentService;
    protected $benefitService;
    protected $faqService;
    protected $workingProcessService;
    protected $pricingService;
    protected $queryService;

    public function __construct(
        MerchantContentService $merchantContentService,
        BenefitService $benefitService,
        WorkingProcessService $workingProcessService,
        FaqService $faqService,
        PricingService $pricingService,
        QueryService $queryService
    ) {
        $this->middleware('maintenance_mode');
        $this->middleware(['prohibited_demo_mode'])->only('register');
        $this->merchantContentService = $merchantContentService;
        $this->benefitService = $benefitService;
        $this->faqService = $faqService;
        $this->workingProcessService = $workingProcessService;
        $this->pricingService = $pricingService;
        $this->queryService = $queryService;
    }


    protected function redirectTo()
    {
        if (app('business_settings')->where('type', 'email_verification')->first()->status == 1 && !isModuleActive('Otp') && !otp_configuration('otp_activation_for_seller')) {
            return redirect('/user-email-verify');
        }
        return redirect('/seller/dashboard');
    }


    public function showRegisterFormStepFirst()
    {
        if (app('business_settings')->where('category_type', 'vendor_configuration')->where('type', 'Multi-Vendor System Activate')->first()->status) {
            if (auth()->check() && auth()->user()->role->type == 'customer') {
                $commisionRepo = new CommisionRepository();
                $data['commissions'] = $commisionRepo->getAllActive();
                $data['content'] = MerchantContent::firstOrFail();
                $data['benefitList'] = $this->benefitService->getAllActive();
                $data['faqList'] = $this->faqService->getAllActive();
                $data['content'] = $this->merchantContentService->getAll();
                $data['pricingList'] = $this->pricingService->getAllActive();
                $data['workProcessList'] = $this->workingProcessService->getAllActive();
                $data['QueryList'] = $this->queryService->getAllActive();
                return view(theme('pages.marchant'), $data);
            } elseif (!auth()->check()) {
                $commisionRepo = new CommisionRepository();
                $data['commissions'] = $commisionRepo->getAllActive();
                $data['content'] = MerchantContent::firstOrFail();
                $data['benefitList'] = $this->benefitService->getAllActive();
                $data['faqList'] = $this->faqService->getAllActive();
                $data['content'] = $this->merchantContentService->getAll();
                $data['pricingList'] = $this->pricingService->getAllActive();
                $data['workProcessList'] = $this->workingProcessService->getAllActive();
                $data['QueryList'] = $this->queryService->getAllActive();
                return view(theme('pages.marchant'), $data);
            } else {
                return abort(404);
            }
        } else {
            Toastr::error(__('auth.multi_vendor_system_is_temporary_disabled'));
            return back();
        }
    }

    public function showRegisterForm($id)
    {
        if (app('business_settings')->where('category_type', 'vendor_configuration')->where('type', 'Multi-Vendor System Activate')->first()->status) {
            if (auth()->check() && auth()->user()->role->type == 'customer') {
                $commisionRepo = new CommisionRepository();
                $commission = $commisionRepo->findByID(base64_decode($id));
                if (session()->has('commission_id')) {
                    session()->forget('commission_id');
                    session()->forget('commission_rate');
                }
                session()->put('commission_id', $commission->id);
                session()->put('commission_rate', $commission->rate);
                if ($commission->id == 3) {
                    $data['pricing_plans'] = Pricing::where('status', 1)->get();
                    $data['content'] = MerchantContent::firstOrFail();
                    return view(theme('pages.merchant_create_by_subscription'), $data);
                } else {
                    session()->forget('pricing_id');
                }
                $registerRepo = new MerchantRepository();
                $registerRepo->customerToSellerConvert([
                    'commission_id' => session()->get('commission_id'),
                    'commission_rate' => session()->get('commission_rate'),
                ]);
                return redirect()->route('seller.dashboard');
            } elseif (!auth()->check()) {
                $commisionRepo = new CommisionRepository();
                $commission = $commisionRepo->findByID(base64_decode($id));
                if (session()->has('commission_id')) {
                    session()->forget('commission_id');
                    session()->forget('commission_rate');
                }
                session()->put('commission_id', $commission->id);
                session()->put('commission_rate', $commission->rate);


                if ($commission->id == 3) {
                    $data['pricing_plans'] = Pricing::where('status', 1)->get();
                    $data['content'] = MerchantContent::firstOrFail();
                    return view(theme('pages.merchant_create_by_subscription'), $data);
                } else {
                    session()->forget('pricing_id');
                }
                return view(theme('pages.merchant_create_step_two'));
            } else {
                return abort(404);
            }
        } else {
            Toastr::error(__('auth.multi_vendor_system_is_temporary_disabled'));
            return back();
        }
    }

    public function showRegisterForm2(Request $request)
    {

        if (app('business_settings')->where('category_type', 'vendor_configuration')->where('type', 'Multi-Vendor System Activate')->first()->status) {
            if (auth()->check() && auth()->user()->role->type == 'customer') {
                if (session()->has('pricing_id')) {
                    session()->forget('pricing_id');
                    session()->forget('pricing_type');
                }
                session()->put('pricing_id', $request->id);
                session()->put('pricing_type', $request->type);
                $data['pricing_plans'] = Pricing::where('status', 1)->get(['name', 'id']);
                $registerRepo = new MerchantRepository();
                $registerRepo->customerToSellerConvert([
                    'commission_id' => session()->get('commission_id'),
                    'commission_rate' => session()->get('commission_rate'),
                    'pricing_id' => session()->get('pricing_id'),
                    'pricing_type' => session()->get('pricing_type'),
                ]);
                return redirect()->route('seller.dashboard');
            } elseif (!auth()->check()) {
                if (session()->has('pricing_id')) {
                    session()->forget('pricing_id');
                    session()->forget('pricing_type');
                }
                session()->put('pricing_id', $request->id);
                session()->put('pricing_type', $request->type);

                $data['row'] = '';
                $data['form_data'] = '';
                if(Module::has('FormBuilder')){
                    if(Schema::hasTable('custom_forms')){
                        $formBuilderRepo = new FormBuilderRepositories();
                        $data['row'] = $formBuilderRepo->find(3);
                        if($data['row']->form_data){
                            $data['form_data'] = json_decode($data['row']->form_data);
                        }
                    }
                }
                $data['pricing_plans'] = Pricing::where('status', 1)->get(['name', 'id']);
                return view(theme('pages.merchant_create_step_two'), $data);
            } else {
                return abort(404);
            }
        } else {
            Toastr::error(__('auth.multi_vendor_system_is_temporary_disabled'));
            return back();
        }
    }

    protected function validator(array $data)
    {

        return Validator::make(
            $data,
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],

            ],
            [
                'name.required' => "This Name Filed is required",
                'email.required' => "This Email is required",
                'email.email' => "This is not a valid email",
                'email.unique' => "Email has already taken",
                'password.required' => "This Password Filed is required",
            ]
        );
    }

    public function register(Request $request)
    {
        // return $request;
        if (app('business_settings')->where('category_type', 'vendor_configuration')->where('type', 'Multi-Vendor System Activate')->first()->status == 0) {
            Toastr::error(__('auth.multi_vendor_system_is_temporary_disabled'));
            return back();
        }

        $this->validator($request->all())->validate();

        if (isModuleActive('Otp') && otp_configuration('otp_activation_for_seller')) {

            try {
                if (!$this->sendOtpForSeller($request)) {
                    Toastr::error(__('otp.something_wrong_on_otp_send'), __('common.error'));
                    return back();
                }
                return view(theme('auth.otp_seller'), compact('request'));
            } catch (Exception $e) {
                LogActivity::errorLog($e->getMessage());
                Toastr::error(__('otp.something_wrong_on_otp_send'), __('common.error'));
                return back();
            }
        }
        event(new Registered($user = $this->create($request)));

        if (auto_approve_seller()) {
            $this->guard()->login($user);
        } else {
            Toastr::success(__('common.successfully_registered') . ' ' . __('auth.wait_for_approval'), __('common.success'));
            return back();
        }

        Toastr::success(__('common.successfully_registered') . ' ' . __('auth.please_verify_your_email'), __('common.success'));

        if ($response = $this->registered($request, $user)) {

            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 201)
            : $this->redirectTo();
    }

    protected function othersFieldValue($data)
    {
        return json_encode($data);
    }


    protected function create($data)
    {
        $c_data = [];
        if($data->has('custom_field')){
            foreach (json_decode($data['custom_field']) as  $key => $f){
                if($data->hasFile($f)){
                    $file = ImageStore::saveImage($data[$f], 165, 165);
                    $c_data[$f] = $file;
                }else{
                    $c_data[$f] = $data[$f];
                }
            }
        }
        
        $user =  User::create([
            'first_name' => $data['name'],
            'email' => $data['email'],
            'role_id' => 5,
            'username' => $data['phone'],
            'verify_code' => sha1(time()),
            'password' => Hash::make($data['password']),
            'others' => $this->othersFieldValue($c_data),
        ]);

        $slug = Str::slug($data['name']) . "-" . $user->id;
        // Auto approve check
        if (auto_approve_seller()) {
            $user->is_active = 1;
        } else {
            $user->is_active = 0;
        }
        $user->slug = $slug;
        $user->save();
        // User Notification Setting Create
        (new UserNotificationSetting())->createForRegisterUser($user->id);
        $this->typeId = EmailTemplateType::where('type', 'register_email_template')->first()->id; //register email templete typeid
        $this->notificationSend("Register", $user->id);

        $seller_account = SellerAccount::create([
            'user_id' => $user['id'],
            'seller_id' => 'BDEXCJ' . rand(99999, 10000000),
            'seller_commission_id' => (session()->has('commission_id')) ? session()->get('commission_id') : 1,
            'commission_rate' => (session()->has('commission_rate')) ? session()->get('commission_rate') : 0,
            'subscription_type' => (session()->has('pricing_id')) ? session()->get('pricing_type') : null,
        ]);
        SellerBusinessInformation::create([
            'user_id' => $user['id']
        ]);
        SellerBankAccount::create([
            'user_id' => $user['id'],
            'business_country' => app('general_setting')->default_country,
            'business_state' => app('general_setting')->default_state
        ]);
        if (session()->has('pricing_id')) {
            SellerSubcription::create([
                'seller_id' => $user['id'],
                'pricing_id' => session()->get('pricing_id')
            ]);
            if (session()->get('pricing_type') == null) {
                $seller_account->update([
                    'subscription_type' => 'monthly'
                ]);
            }
        }

        SellerWarehouseAddress::create([
            'user_id' => $user['id'],
            'warehouse_country' => app('general_setting')->default_country,
            'warehouse_state' => app('general_setting')->default_state
        ]);
        SellerReturnAddress::create([
            'user_id' => $user['id'],
            'return_country' => app('general_setting')->default_country,
            'return_state' => app('general_setting')->default_state
        ]);

        if(!isModuleActive('Otp') && !otp_configuration('otp_activation_for_seller')){
            if (app('business_settings')->where('type', 'email_verification')->first()->status == 1) {
                $code = '<a class="btn btn-success" href="' . url('/verify?code=') . $user['verify_code'] . '">Click Here To Verify Your Account</a>';
                $this->sendVerificationMail($user, $code);
            }
        }

        if (!$user->sidebars()->exists()) {
            $sidebars = Sidebar::where('user_id', 1)->orderBy('position', 'asc')->get();
            foreach ($sidebars as $sidebar) {
                $data = $sidebar->toArray();
                $data['user_id'] = $user->id;

                Sidebar::create($data);
            }
        }

        return $user;
    }


    public function otp_check_for_seller(Request $request)
    {
        try {
            $otp = Session::get('otp');
            $validation_time = Session::get('validation_time');

            if ($otp != $request->otp) {
                Toastr::error(__('otp.invalid_otp'));
                Session::put('code_validation_time', $request->code_validation_time);
                return view(theme('auth.otp_seller'), compact('request'));
            } elseif (date('Y-m-d H:i:s') > $validation_time) {
                Session::put('code_validation_time', 1);
                Toastr::error(__('otp.otp_validation_time_expired'));
                return view(theme('auth.otp_seller'), compact('request'));
            } else {

                Session::forget('otp');
                Session::forget('validation_time');
                Session::forget('code_validation_time');

                event(new Registered($user = $this->create($request->all())));
                $user->update(['is_verified' => 1]);
                if (auto_approve_seller()) {
                    Toastr::success(__('common.successfully_registered'), __('common.success'));
                    $this->guard()->login($user);
                } else {
                    Toastr::success(__('common.successfully_registered') . ' ' . __('auth.wait_for_approval'), __('common.success'));
                    return redirect()->route('register');
                }

                if ($response = $this->registered($request, $user)) {

                    return $response;
                }

                return $request->wantsJson()
                    ? new Response('', 201)
                    : $this->redirectTo();
            }
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return redirect()->route('register');
        }
    }
}
