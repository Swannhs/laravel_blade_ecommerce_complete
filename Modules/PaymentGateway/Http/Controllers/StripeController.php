<?php

namespace Modules\PaymentGateway\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Repositories\OrderRepository;
use \Modules\Wallet\Repositories\WalletRepository;
use Modules\Account\Repositories\TransactionRepository;
use Modules\Account\Entities\Transaction;
use Modules\FrontendCMS\Entities\SubsciptionPaymentInfo;
use App\Traits\Accounts;
use Carbon\Carbon;
use Modules\UserActivityLog\Traits\LogActivity;
use Stripe;

class StripeController extends Controller
{
    use Accounts;

    public function __construct()
    {
        $this->middleware('maintenance_mode');
    } 

    public function payment_page(Request $request)
    {
         return view('paymentgateway::stripe_payment.create');
    }

    public function stripePost($data)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripe = Stripe\Charge::create ([
                "amount" => round($data['amount'] * 100),
                "currency" => "usd",
                "source" => $data['stripeToken'],
                "description" => "Test payment from amazcart.com"
        ]);
        if ($stripe['status'] == "succeeded") {
            $return_data = $stripe['id'];
            if (session()->has('wallet_recharge')) {
                $walletService = new WalletRepository;
                return $walletService->walletRecharge($data['amount'], "4", $return_data);
            }
            if (session()->has('order_payment')) {
                $orderPaymentService = new OrderRepository;
                $order_payment = $orderPaymentService->orderPaymentDone($data['amount'], "4", $return_data, (auth()->check())?auth()->user():null);
                if($order_payment == 'failed'){
                    Toastr::error('Invalid Payment');
                    return redirect(url('/checkout'));
                }
                $payment_id = $order_payment->id;
                Session()->forget('order_payment');
                LogActivity::successLog('Order payment successful.');
                return $payment_id;
            }
            if (session()->has('subscription_payment')) {
                $defaultIncomeAccount = $this->defaultIncomeAccount();
                $transactionRepo = new TransactionRepository(new Transaction);
                $transaction = $transactionRepo->makeTransaction(auth()->user()->first_name." - Subsriction Payment", "in", "Stripe", "subscription_payment", $defaultIncomeAccount, "Subscription Payment", auth()->user()->SellerSubscriptions->latest()->first(), $data['amount'], Carbon::now()->format('Y-m-d'), auth()->id(), null, null);
                auth()->user()->SellerSubscriptions->latest()->first()->update(['last_payment_date' => Carbon::now()->format('Y-m-d')]);
                SubsciptionPaymentInfo::create([
                    'transaction_id' => $transaction->id,
                    'txn_id' => $return_data,
                ]);
                LogActivity::successLog('Subscription payment successful.');
                return true;
            }
        }else {
            return redirect()->route('frontend.welcome');
        }
    }

}
