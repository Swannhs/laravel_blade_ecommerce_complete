<?php

namespace Modules\PaymentGateway\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\OrderRepository;
use Unicodeveloper\Paystack\Paystack;
use Brian2694\Toastr\Facades\Toastr;
use \Modules\Wallet\Repositories\WalletRepository;
use Modules\Account\Repositories\TransactionRepository;
use Modules\Account\Entities\Transaction;
use Modules\FrontendCMS\Entities\SubsciptionPaymentInfo;
use App\Traits\Accounts;
use Carbon\Carbon;
use Modules\UserActivityLog\Traits\LogActivity;

class PaystackController extends Controller
{
    use Accounts;

    public function __construct()
    {
        $this->middleware('maintenance_mode');
    } 

    public function redirectToGateway()
    {
        $paystack = new Paystack(env('PAYSTACK_SECRET'), env('PAYSTACK_PAYMENT_URL'));
        return $paystack->getAuthorizationUrl()->redirectNow();
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
                session()->forget('wallet_recharge');
                return $walletService->walletRecharge($amount, "5", $response);

            }
            if (session()->has('order_payment')) {
                $amount = $payment['data']['amount'] / 100;
                $response = $payment['data']['reference'];
                $orderPaymentService = new OrderRepository;
                $order_payment = $orderPaymentService->orderPaymentDone($amount, "5", $response, (auth()->check())?auth()->user():null);
                if($order_payment == 'failed'){
                    Toastr::error('Invalid Payment');
                    return redirect(url('/checkout'));
                }
                $payment_id = $order_payment->id;
                Session()->forget('order_payment');
                $data['payment_id'] = encrypt($payment_id);
                $data['gateway_id'] = encrypt(5);
                $data['step'] = 'complete_order';
                LogActivity::successLog('Order payment successful.');
                return redirect()->route('frontend.checkout', $data);
            }
            if (session()->has('subscription_payment')) {
                $amount = $payment['data']['amount'] / 100;
                $response = $payment['data']['reference'];
                $defaultIncomeAccount = $this->defaultIncomeAccount();
                $transactionRepo = new TransactionRepository(new Transaction);
                $transaction = $transactionRepo->makeTransaction(auth()->user()->first_name." - Subsriction Payment", "in", "PayStack", "subscription_payment", $defaultIncomeAccount, "Subscription Payment", auth()->user()->SellerSubscriptions->latest()->first(), $amount, Carbon::now()->format('Y-m-d'), auth()->id(), null, null);
                auth()->user()->SellerSubscriptions->latest()->first()->update(['last_payment_date' => Carbon::now()->format('Y-m-d')]);
                SubsciptionPaymentInfo::create([
                    'transaction_id' => $transaction->id,
                    'txn_id' => $response,
                ]);
                session()->forget('subscription_payment');
                Toastr::success(__('common.payment_successfully'),__('common.success'));
                \LogActivity::successLog('Subscription payment successful.');
                return redirect()->route('seller.dashboard');
            }
        }else {
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

}
