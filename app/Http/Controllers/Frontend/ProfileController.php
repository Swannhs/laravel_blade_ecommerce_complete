<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\GoogleAnalytics4;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Modules\Customer\Entities\CustomerAddress;
use Modules\Visitor\Entities\VisitorHistory;
use Modules\Marketing\Entities\ReferralCode;
use Modules\Account\Services\ReportService;
use Modules\MultiVendor\Entities\SellerAccount;
use Modules\Seller\Entities\SellerProduct;
use Modules\Review\Entities\ProductReview;
use Modules\Refund\Entities\RefundRequest;
use Modules\Refund\Entities\RefundRequestDetail;
use Modules\Account\Entities\Transaction;
use Modules\Marketing\Entities\CouponUse;
use Modules\Marketing\Entities\Coupon;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Setup\Entities\Country;
use App\Models\Subscription;
use App\Models\SearchTerm;
use App\Models\Wishlist;
use App\Models\Order;
use App\Models\User;
use App\Models\Cart;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Setup\Repositories\CityRepository;
use Modules\Setup\Repositories\StateRepository;
use Modules\UserActivityLog\Traits\LogActivity;
use Spatie\Analytics\Analytics;
use Spatie\Analytics\Period;


class ProfileController extends Controller
{
    use GoogleAnalytics4;

    public function __construct()
    {
        $this->middleware(['maintenance_mode','auth','customer']);
    }

    public function index(){
        try{
            $data['user_info'] = User::find(auth()->user()->id);
            $data['addressList'] = CustomerAddress::where('customer_id',auth()->user()->id)->get();
            $data['countries'] = Country::where('status', 1)->orderBy('name')->get();
            $data['states'] = (new StateRepository())->getByCountryId(app('general_setting')->default_country)->where('status', 1);
            $data['cities'] = (new CityRepository())->getByStateId(app('general_setting')->default_state)->where('status', 1);
            if (auth()->user()->role->type != 'customer') {
                return view('backEnd.pages.customer_data.profile',$data);
            }
            else {
                return view(theme('pages.profile.profile'),$data);
            }
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }


    public function dashboard()
    {

        try{
            if (auth()->user()->role->type == "superadmin" || auth()->user()->role->type == "admin" || auth()->user()->role->type == "staff") {
                if (app('business_settings')->where('type', 'google_analytics')->first()->status == 1 &&  env('ANATYTIC_RESULT_DASHBOARD') == 1){
                    $analytic = App::make(Analytics::class);
                    $a = $analytic->fetchVisitorsAndPageViews(Period::days(1));
                    $data['total_page_visitor'] = $a->sum('visitors');
                    $data['total_page_views'] = $a->sum('pageViews');
                    $userType = $analytic->fetchUserTypes(Period::days(3));
                    $data['total_new_visitor'] = $userType->where('type', 'New Visitor')->sum('sessions');
                    $data['total_old_views'] = $userType->where('type', 'Returning Visitor')->sum('sessions');
                    $data['total_in_session'] = $data['total_new_visitor'] + $data['total_old_views'];
//                    $ck = $analytic->performQuery((Period::days(1)),'ga:users,ga:pageviews',  ['dimensions' => 'ga:date,ga:pageTitle']);
                }

                $data['totalProducts'] = Product::where('is_approved',1)->get()->count();
                $data['totalSellers'] = isModuleActive('MultiVendor')?SellerAccount::all()->count():0;
                $data['totalCustomers'] = User::where('role_id',4)->get()->count();
                $data['totalvisitors'] = VisitorHistory::VisitorCount('today');
                $data['total_sale'] = Order::TotalSaleCount('today');
                $data['total_review'] = ProductReview::TotalReviewCount('today');
                $data['categories'] = Category::whereHas('products')->limit(10)->take(10)->get();
                $data['topSaleCategories'] = Category::orderBy('total_sale','desc')->limit(10)->take(10)->get();
                $data['categoriesTotal'] = Category::where('status', 1)->whereHas('products')->get()->count();
                $data['top_ten_products'] = SellerProduct::with('product','product.categories','product.brand')->orderBy('total_sale','desc')->limit(10)->take(10)->get();
                $data['top_ten_sellers'] = isModuleActive('MultiVendor')?SellerAccount::with('user')->orderBy('total_sale_qty','desc')->limit(10)->take(10)->get():[];
                $data['coupon_wise_sales'] = Coupon::with('coupon_uses')->whereHas('coupon_uses')->limit(10)->take(10)->latest()->get();
                $data['total_coupon'] = Coupon::with('coupon_uses')->get();
                $data['total_order'] = Order::OrderInfo('today', 'all');
                $data['total_pending_order'] = Order::OrderInfo('today', 0);
                $data['total_completed_order'] = Order::OrderInfo('today', 1);
                $data['income'] = Transaction::GetIncome('today');
                $data['expense'] = Transaction::GetExpense('today');
                $data['total_revenue'] = $data['income'] - $data['expense'];
                $data['new_customers'] = User::where('role_id', 4)->latest()->limit(10)->take(10)->get();
                $data['total_active_customers'] = User::where('role_id', 4)->where('is_active', 1)->get()->count();
                $data['total_subscriber'] = Subscription::all()->count();
                $data['latest_search_keywords'] = SearchTerm::latest()->limit(10)->take(10)->get();
                $data['recently_added_products'] = SellerProduct::with('product','product.categories','product.brand')->latest()->take(10)->get();
                $data['top_refferers'] = ReferralCode::with('user')->orderBy('total_used','desc')->take(10)->get();
                $data['latest_orders'] = Order::with('packages', 'customer')->latest()->take(10)->get();
                $data['graph_total_product'] = SellerProduct::where('status',1)->select('id')->get();
                $data['graph_admin_product'] = SellerProduct::whereHas('seller', function($q){
                                                    $q->where('role_id', 1);
                                                })->where('status',1)->get();
                $data['graph_seller_product'] = SellerProduct::whereHas('seller', function($q){
                                                    $q->where('role_id', 5);
                                                })->where('status',1)->get();

                $data['graph_total_sales'] = count(Order::all());
                $data['graph_cancelled_sales'] = count(Order::where('is_cancelled', 1)->get());
                $data['graph_completed_sales'] = count(Order::where('is_completed', 1)->get());
                $data['graph_sales_today'] = count(Order::where('is_confirmed', 0)->whereBetween('created_at', [Carbon::now()->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->get());
                $data['graph_pending_sales_today'] = count(Order::where('is_confirmed', 0)->whereBetween('created_at', [Carbon::now()->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->get());
                $data['graph_processing_sales_today'] = count(Order::where('is_confirmed', 1)->whereBetween('created_at', [Carbon::now()->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->get());
                $data['graph_completed_sales_today'] = count(Order::where('is_completed', 1)->whereBetween('created_at', [Carbon::now()->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->get());
                $data['graph_total_sellers'] = isModuleActive('MultiVendor')?count(SellerAccount::all()):0;
                $data['graph_normal_sellers'] = isModuleActive('MultiVendor')?count(SellerAccount::where('is_trusted', 0)->get()):0;
                $data['graph_trusted_sellers'] = isModuleActive('MultiVendor')?count(SellerAccount::where('is_trusted', 1)->get()):0;

                $data['top_disputed_customer'] = DB::table('refund_requests')
                                                    ->select(DB::raw('customer_id as customer_id'), DB::raw('sum(total_return_amount) as total'))
                                                    ->groupBy(DB::raw('customer_id'))
                                                    ->orderBy('total','desc')
                                                    ->take(10)
                                                    ->get();
                $data['top_disputed_sellers'] = DB::table('refund_request_details')
                                                    ->select(DB::raw('seller_id as seller_id'), DB::raw('count(seller_id) as total'))
                                                    ->groupBy(DB::raw('seller_id'))
                                                    ->orderBy('total','desc')
                                                    ->take(10)
                                                    ->get(['seller_id']);
                $data['graph_total_authorized_order'] = count(Order::where('customer_id', '!=', null)->whereBetween('created_at', [Carbon::now()->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->get());;
                $data['graph_total_guest_order'] = count(Order::where('customer_id', null)->whereBetween('created_at', [Carbon::now()->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->get());;
                $data['total_product_in_cart'] = Cart::TotalCart('today');
                return view('backEnd.dashboard', $data);
            }else {
                $data['total_order_count'] = Order::where('customer_id', auth()->user()->id)->count();
                $data['total_confirmed_order_count'] = Order::where('customer_id', auth()->user()->id)->where('is_confirmed',1)->count();
                $data['total_completed_order_count'] = Order::where('customer_id', auth()->user()->id)->where('is_completed',1)->count();
                $data['total_processing_order_count'] = Order::where('customer_id', auth()->user()->id)->where('is_confirmed',1)->where('is_completed',0)->count();
                $data['total_wishlist_count'] = Wishlist::where('user_id', auth()->user()->id)->count();
                $data['total_item_in_carts'] = Cart::where('user_id', auth()->user()->id)->count();
                $data['total_success_refund'] = RefundRequest::where('customer_id', auth()->user()->id)->where('is_completed', 1)->count();
                $data['total_coupon_used'] = CouponUse::where('user_id', auth()->user()->id)->count();
                return view(theme('pages.profile.dashboard'), $data);
            }
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function dashboardCards($type)
    {
        $total_visitors = VisitorHistory::VisitorCount($type);
        $total_sale = Order::TotalSaleCount($type);
        $total_order = Order::OrderInfo($type, 'all');
        $total_pending_order = Order::OrderInfo($type, 0);
        $total_completed_order = Order::OrderInfo($type, 1);
        $total_review = ProductReview::TotalReviewCount('today');
        $income = Transaction::GetIncome($type);
        $expense = Transaction::GetExpense($type);
        $total_revenue = $income - $expense;
        return [
            'total_visitors' => $total_visitors,
            'total_sale' => single_price($total_sale),
            'total_order' => $total_order,
            'total_pending_order' => $total_pending_order,
            'total_completed_order' => $total_completed_order,
            'total_review' => $total_review,
            'total_revenue' => single_price($total_revenue),
        ];
    }

    public function order(){

        try{

            return view(theme('pages.profile.order'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function refund(){

        try{

            return view(theme('pages.profile.refund'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }


}
