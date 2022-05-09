<?php

namespace Modules\PaymentGateway\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\OrderRepository;
use \Modules\Wallet\Repositories\WalletRepository;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Account\Repositories\TransactionRepository;
use Modules\Account\Entities\Transaction;
use Modules\FrontendCMS\Entities\SubsciptionPaymentInfo;
use App\Traits\Accounts;
use Carbon\Carbon;
use Modules\UserActivityLog\Traits\LogActivity;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    use Accounts;

    public function __construct()
    {
        $this->middleware('maintenance_mode');
    } 

    public function payWithRazorpay()
    {
        return view('paymentgateway::razorPay.index');
    }

    public function payment($data)
    {
        //Input items of form
        $input = $data;
        //get API Configuration
        $api = new Api(env("RAZOR_KEY"), env("RAZORPAY_SECRET"));
        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
                $return_data = $response['id'];
                if (session()->has('wallet_recharge')) {

                    $amount = $response['amount'] / 100;
                    $walletService = new WalletRepository;
                    Session()->forget('order_payment');
                    return $walletService->walletRecharge($amount, "6", $return_data);
                    
                }
                if (session()->has('order_payment')) {
                    $amount = $response['amount'] / 100;
                    $orderPaymentService = new OrderRepository;
                    $order_payment = $orderPaymentService->orderPaymentDone($amount, "6", $return_data, (auth()->check())?auth()->user():null);
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
                    $amount = $response['amount'] / 100;
                    $defaultIncomeAccount = $this->defaultIncomeAccount();
                    $transactionRepo = new TransactionRepository(new Transaction);
                    $transaction = $transactionRepo->makeTransaction(auth()->user()->first_name." - Subsriction Payment", "in", "Razor Pay", "subscription_payment", $defaultIncomeAccount, "Subscription Payment", auth()->user()->SellerSubscriptions->latest()->first(), $amount, Carbon::now()->format('Y-m-d'), auth()->id(), null, null);
                    auth()->user()->SellerSubscriptions->latest()->first()->update(['last_payment_date' => Carbon::now()->format('Y-m-d')]);
                    SubsciptionPaymentInfo::create([
                        'transaction_id' => $transaction->id,
                        'txn_id' => $return_data,
                    ]);
                    session()->forget('subscription_payment');
                    Toastr::success(__('common.payment_successfully'),__('common.success'));
                    LogActivity::successLog('Subscription payment successful.');
                    return redirect()->route('seller.dashboard');
                }
            } catch (\Exception $e) {

            LogActivity::errorLog($e->getMessage());
                return  $e->getMessage();
            }
        }
        Toastr::success(__('order.payment_successful_your_order_will_be_despatched_in_the_next_48_hours'),__('common.success'));
        return redirect()->route('frontend.welcome');
    }
}
