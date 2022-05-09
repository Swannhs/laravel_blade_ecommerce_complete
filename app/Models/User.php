<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Order;
use App\Models\OrderPackageDetail;
use App\Models\Profile;
use App\Models\SocialProvider;
use Modules\Affiliate\Entities\AffiliateReferralPayment;
use Modules\Affiliate\Entities\AffiliateReferralUser;
use Modules\Affiliate\Entities\AffiliateUserWallet;
use Modules\Affiliate\Entities\AffiliateWithdraw;
use Modules\Wallet\Entities\WalletBalance;
use Modules\RolePermission\Entities\Permission;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Modules\Leave\Entities\ApplyLeave;
use Modules\Refund\Entities\RefundRequest;
use Modules\Leave\Entities\LeaveDefine;
use Modules\RolePermission\Entities\Role;
use Modules\Attendance\Entities\Attendance;
use Modules\Sale\Entities\Sale;
use Modules\Agent\Entities\Agent;
use Modules\MultiVendor\Entities\SubSeller;
use Modules\Agent\Entities\AgentHistory;
use Modules\Account\Entities\ChartOfAccount;
use Modules\Customer\Entities\CustomerAddress;
use Modules\Marketing\Entities\ReferralCode;
use Modules\Review\Entities\SellerReview;
use Modules\Setup\Entities\ApplyLoan;

use Modules\MultiVendor\Entities\SellerAccount;
use Modules\MultiVendor\Entities\SellerSubcription;
use Modules\Seller\Entities\SellerProduct;
use Modules\MultiVendor\Entities\SellerBankAccount;
use Modules\MultiVendor\Entities\SellerBusinessInformation;
use Modules\MultiVendor\Entities\SellerReturnAddress;
use Modules\MultiVendor\Entities\SellerWarehouseAddress;
use Laravel\Sanctum\HasApiTokens;
use Modules\GeneralSetting\Entities\Currency;
use Modules\Language\Entities\Language;
use Modules\SidebarManager\Entities\Sidebar;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username' ,
        'email',
        'role_id',
        'password',
        'avatar',
        'is_verified',
        'is_active',
        'verify_code',
        'phone',
        'date_of_birth',
        'description',
        'secret_login',
        'secret_logged_in_by_user',
        'affiliate_request',
        'accept_affiliate_request',
        'others',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            Cache::forget('MegaMenu');
        });
        self::updated(function ($model) {
            Cache::forget('MegaMenu');
        });
        self::deleted(function ($model) {
            Cache::forget('MegaMenu');
        });

    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends  = [
        'name'
    ];

    public function getNameAttribute()
    {
        return $this->first_name.' '. $this->last_name;
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id')->withDefault();
    }

    public function sub_seller()
    {
        return $this->hasOne(SubSeller::class, 'user_id', 'id')->withDefault();
    }

    public function social_providers()
    {
        return $this->hasMany(SocialProvider::class, 'user_id', 'id');
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function agent()
    {
        return $this->hasOne(Agent::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class,'agent_user_id');
    }

    public function agent_histories()
    {
        return $this->hasMany(AgentHistory::class,'user_id');
    }

    public function accounts()
    {
        return $this->morphMany(ChartOfAccount::class, 'contactable');
    }

    public function loans()
    {
        return $this->hasMany(ApplyLoan::class)->where('approval',1);
    }

    public function getLoanInfoAttribute()
    {
        $loans = $this->loans;

        $total_loan = $loans->sum('amount');

        $total_paid = $loans->sum('paid_loan_amount');

        $total_due = $total_loan - $total_paid;

        return [
            'total_loan' => $total_loan,
            'total_paid' => $total_paid,
            'total_due' => $total_due,
        ];
    }

    public function getAccountsAttribute()
    {
        $sales = $this->sales;
        $payable_amount = $sales->sum('payable_amount');

        $paid_amount = 0;
        $sales_return_amount = 0;
        $debit_amount = 0;
        $crebit_amount = 0;
        $total_amount = 0;
        $chart_account = ChartOfAccount::where('contactable_type', 'App\User')->where('contactable_id', $this->id)->first();
        foreach ($chart_account->transactions as $transaction) {
            if ($transaction->type == 'Dr') {
                $debit_amount += $transaction->amount;
            }else {
                $crebit_amount += $transaction->amount;
            }
        }
        foreach ($sales as $sale)
        {
            $paid_amount += $sale->payments->sum('amount');
            $sales_return_amount += $sale->items->sum('return_amount');
        }

        $total_amount = $payable_amount + $this->agent->opening_balance + $crebit_amount  - $sales_return_amount - $debit_amount;
        $due_amount = $payable_amount + $crebit_amount - $paid_amount;

        $accounts['total'] = $total_amount;
        $accounts['paid'] = $paid_amount;
        $accounts['due'] = $due_amount;
        $accounts['total_invoice'] = count($sales);
        $accounts['due_invoice'] = count($sales->where('is_approved', 0));

        return $accounts;
    }

    public function leaves()
    {
        return $this->hasMany(ApplyLeave::class)->CarryForward();
    }

    public function leaveDefines()
    {
        return $this->hasMany(LeaveDefine::class,'role_id','role_id');
    }


    public function getCarryForwardAttribute()
    {
        $total_leave = $this->leaveDefines->sum('total_days');
        $leave = $this->leaves->sum('total_days');

        return $total_leave - $leave;
    }

    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name).' '.ucfirst($this->last_name);
    }

    public function SellerAccount(){
        return $this->hasOne(SellerAccount::class, 'user_id', 'id');
    }


    public function SellerSubscriptions(){
        return $this->hasOne(SellerSubcription::class, 'seller_id', 'id');
    }
    public function SellerBankAccount(){
        return $this->hasOne(SellerBankAccount::class, 'user_id', 'id');
    }
    public function SellerBusinessInformation(){
        return $this->hasOne(SellerBusinessInformation::class, 'user_id', 'id');
    }
    public function SellerWarehouseAddress(){
        return $this->hasOne(SellerWarehouseAddress::class, 'user_id', 'id');
    }
    public function SellerReturnAddress(){
        return $this->hasOne(SellerReturnAddress::class, 'user_id', 'id');
    }
    public function order_packages()
    {
        return $this->hasMany(OrderPackageDetail::class,'seller_id');
    }
    public function seller_products(){
        return $this->hasMany(SellerProduct::class, 'user_id', 'id');
    }

    public function getSellerProductsAPIAttribute(){
        return SellerProduct::with('skus','product','reviews.customer','reviews.images')->where('user_id', $this->id)->where('status', 1)->paginate(10);
    }

    public function customerAddresses(){
        return $this->hasMany(CustomerAddress::class,'customer_id','id');
    }

    public function customerShippingAddress(){
        return $this->hasOne(CustomerAddress::class, 'customer_id','id')->where('is_shipping_default', 1);
    }

    public function wallet_balances(){
        return $this->hasMany(WalletBalance::class);
    }

    public function orders(){
        return $this->hasMany(Order::class,'customer_id','id');
    }

    public function getSellerCurrentWalletAmountsAttribute()
    {
        // new
        $deposite = $this->wallet_balances->where('type', 'Deposite')->where('status', 1)->sum('amount');
        $withdraw = $this->wallet_balances->where('type', 'Withdraw')->where('status', 1)->sum('amount');
        $expense = $this->wallet_balances->where('type', 'Refund')->where('status', 1)->sum('amount');
        $income = $this->wallet_balances->where('type', 'Sale Payment')->where('status', 1)->sum('amount');
        $expensed = $this->wallet_balances->where('status',1)->where('type', 'Cart Payment')->sum('amount');
        $rest_money = $deposite + $income - $expense - $withdraw-$expensed;
        return $rest_money;


    }

    public function getSellerRefundedAmountsAttribute()
    {
        $expense = $this->wallet_balances->where('type', 'Refund')->where('status', 1)->sum('amount');
        return $expense;
    }

    public function getCustomerCurrentWalletAmountsAttribute()
    {
        // new
         $withdraw = $this->wallet_balances->where('type', 'Withdraw')->where('status', 1)->sum('amount');

        $deposite = $this->wallet_balances->where('status',1)->where('type', 'Deposite')->sum('amount');
        $refund_back = $this->wallet_balances->where('status',1)->where('type', 'Refund Back')->sum('amount');
        $expensed = $this->wallet_balances->where('status',1)->where('type', 'Cart Payment')->sum('amount');
        $rest_money = $deposite + $refund_back - $expensed - $withdraw;
        return $rest_money;
    }

    public function getCustomerCurrentWalletPendingAmountsAttribute()
    {
        $deposite = $this->wallet_balances->where('status', 0)->where('type', 'Deposite')->sum('amount');
        $refund_back = $this->wallet_balances->where('status', 0)->where('type', 'Refund Back')->sum('amount');
        $expensed = $this->wallet_balances->where('status', 0)->where('type', 'Cart Payment')->sum('amount');
        $rest_money = $deposite + $refund_back - $expensed;
        return $rest_money;
    }

    public function getSellerPendingWithdrawAmountsAttribute()
    {
        $withdraw = $this->wallet_balances->where('type', 'Withdraw')->where('status', 0)->sum('amount');
        return $withdraw;
    }

    public function getSellerWithdrawAmountsAttribute()
    {
        $withdraw = $this->wallet_balances->where('type', 'Withdraw')->where('status', 1)->sum('amount');
        return $withdraw;
    }

    public function getSellerRefundBackAmountsAttribute()
    {
        $expense = $this->wallet_balances->where('type', 'Refund')->where('status', 1)->sum('amount');
        return $expense;
    }

    public function referralCode(){
        return $this->hasOne(ReferralCode::class,'user_id','id');

    }
    public function sellerReviews(){
        return $this->hasMany(SellerReview::class,'seller_id','id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'sub_seller_accesses','user_id','permission_id');
    }

    public function refunds()
    {
        return $this->hasMany(RefundRequest::class, 'customer_id','id');
    }

    public function sidebars()
    {
        return $this->hasMany(Sidebar::class);
    }

    public function currency(){
        return $this->belongsTo(Currency::class,'currency_id', 'id');
    }

    public function language(){
        return $this->belongsTo(Language::class,'lang_code','code');
    }

    public function isReferralUser()
    {
        return $this->hasOne(AffiliateReferralUser::class,'user_id');
    }
    public function affiliateWallet()
    {
        return $this->hasOne(AffiliateUserWallet::class,'user_id');
    }
    public function affiliateTransaction()
    {
        return $this->hasMany(AffiliateWithdraw::class,'user_id');
    }

    public function affiliateCommissions()
    {
        return $this->hasMany(AffiliateReferralPayment::class,'payment_to');
    }

    public function scopeActiveSeller($query){
        $query = $query->where('is_active', 1)->whereHas('role', function($q1){
            return $q1->where('type','seller');
        });
        $query->whereHas('SellerAccount', function ($q1) {
            return $q1->where('holiday_mode', 0)->orWhere('holiday_date', '!=', date('Y-m-d'))->orWhere(function ($q2) {
                return $q2->where('holiday_date_start', '>', date('Y-m-d'))->where('holiday_date_end', '<', date('Y-m-d'))
                    ->orWhere('holiday_date_start', '>', date('Y-m-d'))->orWhere('holiday_date_end', '<', date('Y-m-d'));
            });
        })->whereHas('SellerSubscriptions', function ($q5) {
            return $q5->where('expiry_date', '>', date('Y-m-d'))->whereHas('user.SellerAccount', function ($q6) {
                return $q6->where('seller_commission_id', 3);
            });
        })->orWhereHas('SellerAccount',function($q7){
            return $q7->where('seller_commission_id','!=',3)
            ->where('holiday_mode', 0)->orWhere('holiday_date', '!=', date('Y-m-d'))->orWhere(function ($q2) {
                return $q2->where('holiday_date_start', '>', date('Y-m-d'))->where('holiday_date_end', '<', date('Y-m-d'))
                    ->orWhere('holiday_date_start', '>', date('Y-m-d'))->orWhere('holiday_date_end', '<', date('Y-m-d'));
            });
        });
        return $query;
    }
}
