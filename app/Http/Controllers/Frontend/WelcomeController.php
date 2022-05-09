<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use App\Services\ContactService;
use Illuminate\Http\Request;
use Modules\FrontendCMS\Entities\DynamicPage;
use Illuminate\Support\Facades\Auth;
use Modules\Appearance\Entities\Header;
use Modules\FrontendCMS\Entities\HomePageSection;
use App\Repositories\ProductRepository;
use Modules\Seller\Entities\SellerProduct;
use Modules\Menu\Entities\Menu;
use Modules\Product\Entities\Category;
use Modules\Visitor\Entities\VisitorHistory;
use Modules\Visitor\Entities\IgnoreIP;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Stevebauman\Location\Facades\Location;
use Carbon\Carbon;
use Exception;
use Browser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Modules\Product\Entities\ProductTag;
use Modules\MultiVendor\Entities\SellerAccount;
use Modules\UserActivityLog\Traits\LogActivity;

class WelcomeController extends Controller
{

    protected $subscribe;

    public function __construct(SubscriptionService $subscribe)
    {
        $this->subscribe = $subscribe;
        $this->middleware('maintenance_mode');
    }
    public function index(Request $request)
    {


        try {
            $ignored = IgnoreIP::where('ip', request()->ip())->first();
            $ipExists = VisitorHistory::where('date', Carbon::now()->format('y-m-d'))->where('visitors', request()->ip())->first();
            if (!$ipExists && !$ignored) {
                // Location Check
                $location = Location::get(request()->ip());
                if ($location) {
                    $country = $location->countryName ?? '';
                    $region = $location->regionName ?? '';
                    $location = $country . ", " . $region;
                } else {
                    $location = "";
                }
                VisitorHistory::create(['visitors' => request()->ip(), 'date' => Carbon::now()->format('y-m-d'), 'agent' => Browser::browserFamily() . '-' . Browser::browserVersion() . '-' . Browser::browserEngine() . '-' . Browser::platformName(), 'device' => Browser::platformName(), 'location' => $location]);
            }
            $CategoryList = Category::where('parent_id', 0)->get();

            $widgets = HomePageSection::all();
            $previous_route = session()->get('previous_user_last_route');
            $previous_user_id = session()->get('previous_user_id');
            if ($previous_route != null) {
                session()->forget('previous_user_id');
                session()->forget('previous_user_last_route');
                return redirect($previous_route);
            } else {
                return view(theme('welcome'), compact('CategoryList', 'widgets'));
            }
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function get_more_products(Request $request)
    {
        if ($request->ajax()) {
            $more_products = HomePageSection::where('section_name', 'more_products')->first();
            $data['products'] = $more_products->getHomePageProductByQuery();
            return view(theme('partials._get_products'), $data);
        }
    }

    public function ajax_search_for_product(Request $request)
    {
        try {
            $productService = new ProductRepository(new SellerProduct);
            $data = $productService->searchProduct($request->all());
            return response()->json($data,200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e;
        }
    }

    public function shopping_from_recent_viewed()
    {
        $productService = new ProductRepository(new SellerProduct);
        if (auth()->check()) {
            $sellerProductsIds = $productService->lastRecentViewinfo();
            $sellerProducts = $productService->recentViewedProducts($sellerProductsIds);
            return view(theme('pages.shopping'), compact('sellerProducts'));
        } else {
            if (session()->has('recent_viewed_products') && session()->get('recent_viewed_products') != null) {
                $sellerProducts = $productService->recentViewedProducts(session()->get('recent_viewed_products')->unique('product_id')->pluck('product_id'));
                return view(theme('pages.shopping'), compact('sellerProducts'));
            } else {
                return back();
            }
        }
    }

    public function secret_logout()
    {
        $user = User::findOrFail(auth()->user()->id);

        $previous_user_id = null;
        if(Session::has('secret_logged_in_by_user')){
            $previous_user_id = Session::get('secret_logged_in_by_user');
            $user->update([
                'secret_login' => 0,
            ]);
        }
        auth()->logout();
        session()->flush();

        if ($previous_user_id != null) {
            Auth::loginUsingId($previous_user_id);
            Session::put('ip', request()->ip());
            return redirect()->route('admin.merchants_list');
        } else {
            Toastr::success(__('auth.logout_successfully'), __('common.success'));
            Session::put('ip', request()->ip());
            return redirect(url('/'));
        }
    }



    public function subscription(Request $request)
    {
        $request->validate([
            'email' => 'email|required|unique:subscriptions'
        ], [
            'email.required' => __('validation.please_fill_with_valid_email'),
            'email.unique' => __('validation.you_are_already_subscribed'),
            'email' => __('validation.please_fill_with_valid_email')
        ]);
        try {

            $this->subscribe->store($request->except('_token'));
            LogActivity::successLog('subscription added successful.');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }


    public function static($slug)
    {

        $pageData = DynamicPage::where('is_static', 0)->where('slug', $slug)->firstOrFail();
        if (isset($pageData)) {
            return view(theme('pages.static_page'), compact('pageData'));
        } else {
            abort(404);
        }
    }

    public function contactForm(Request $request, ContactService $contact)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'query_type' => 'required',
            'message' => 'required'
        ]);

        try {

            $contact->store($request);

            $details = [
                'name' => $request->name,
                'email' => $request->email,
                'query_type' => $request->query_type,
                'message' => $request->message,
            ];
            contactMail($details);
            LogActivity::successLog('contact created successful.');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }
    public function emailVerify()
    {
        $user = Auth::user();
        if (isset($user) && $user->is_verified == 0) {
            return view(theme('pages.email_verify'), compact('user'));
        } else {
            return abort(404);
        }
    }
}
