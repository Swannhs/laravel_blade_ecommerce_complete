<?php

namespace Modules\PaymentGateway\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Wallet\Entities\WalletBalance;
use Modules\Wallet\Entities\BankPayment;
use App\Traits\ImageStore;
use Illuminate\Support\Arr;
use Brian2694\Toastr\Facades\Toastr;
use App\Repositories\OrderRepository;
use \Modules\Wallet\Repositories\WalletRepository;
use Modules\Account\Repositories\TransactionRepository;
use Modules\Account\Entities\Transaction;
use Modules\FrontendCMS\Entities\SubsciptionPaymentInfo;
use App\Traits\Accounts;
use Carbon\Carbon;
use Modules\UserActivityLog\Traits\LogActivity;

class BankPaymentController extends Controller
{
    use ImageStore, Accounts;

    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }    

    public function store($data)
    {
        if(isset($data['image'])){
            $data = Arr::add($data, 'image_src', $this->saveImage($data['image']));
        }
        $bank_payment = BankPayment::create([
            'bank_name' => $data['bank_name'],
            'branch_name' => $data['branch_name'],
            'account_number' => $data['account_number'],
            'account_holder' => $data['account_holder'],
            'image_src' => isset($data['image_src'])?$data['image_src']:null,
        ]);
        LogActivity::successLog('bank payment create successful.');
        if (session()->has('wallet_recharge')) {
            $wallet_deposit = WalletBalance::create([
                'walletable_type' => "Modules\Wallet\Entities\BankPayment",
                'walletable_id' => $bank_payment->id,
                'user_id' => auth()->user()->id,
                'type' => "Deposite",
                'amount' => $data['deposit_amount'],
                'payment_method' => $data['method'],
            ]);
            session()->forget('wallet_recharge');
            LogActivity::successLog('wallet recharge successful.');
        }elseif (session()->has('order_payment')) {
            session()->put('bank_detail_id', $bank_payment->id);
            session()->forget('order_payment');
            $order_paymentRepo = new OrderRepository;
            $order_payment = $order_paymentRepo->orderPaymentDone($data['bank_amount'], 7, "none", (auth()->check())?auth()->user():null);
            LogActivity::successLog('order payment successful.');
            return $order_payment->id;
        }elseif (session()->has('subscription_payment')) {
            $defaultIncomeAccount = $this->defaultIncomeAccount();
            $transactionRepo = new TransactionRepository(new Transaction);
            $transaction = $transactionRepo->makeTransaction(auth()->user()->first_name." - Subsriction Payment", "in", "Bank Payment", "subscription_payment", $defaultIncomeAccount, "Subscription Payment", auth()->user()->SellerSubscriptions->latest()->first(), $data['deposit_amount'], Carbon::now()->format('Y-m-d'), auth()->id(), null, null);
            auth()->user()->SellerSubscriptions->latest()->first()->update(['last_payment_date' => Carbon::now()->format('Y-m-d')]);
            $subscription_info = SubsciptionPaymentInfo::create([
                'transaction_id' => $transaction->id,
                'txn_id' => "none",
            ]);
            $bank_payment->update(['itemable_id' => $subscription_info->id, 'itemable_type' => SubsciptionPaymentInfo::class]);
            LogActivity::successLog('Subscription payment successful.');
        }

    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paystack = new Paystack(env('PAYSTACK_SECRET_KEY'), env('PAYSTACK_PAYMENT_URL'));
        $payment = $paystack->getPaymentData();
        if ($payment['status'] == "true") {
            if (session()->has('wallet_recharge')) {
                $amount = $payment['data']['amount'] / 100;
                $response = $payment['data']['reference'];
                $walletService = new WalletRepository;
                $walletService->walletRecharge($amount, "PayStack", $response);
                return redirect()->route('my-wallet.index', auth()->user()->role->type);
            }
        }else {
            Toastr::error(__('common.operation_failed'));
            return redirect()->route('my-wallet.index', auth()->user()->role->type);
        }
    }

}
