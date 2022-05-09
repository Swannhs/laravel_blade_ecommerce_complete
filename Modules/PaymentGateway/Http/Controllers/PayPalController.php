<?php

namespace Modules\PaymentGateway\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\OrderRepository;
use \Modules\Wallet\Repositories\WalletRepository;
use Omnipay\Omnipay;
use Modules\Account\Repositories\TransactionRepository;
use Modules\Account\Entities\Transaction;
use Modules\FrontendCMS\Entities\SubsciptionPaymentInfo;
use App\Traits\Accounts;
use Carbon\Carbon;
use Brian2694\Toastr\Facades\Toastr;
use Modules\UserActivityLog\Traits\LogActivity;

class PayPalController extends Controller
{
    use Accounts;
    public $payPalGateway;

    public function __construct()
    {
        $this->middleware('maintenance_mode');

        $this->payPalGateway = Omnipay::create('PayPal_Rest');
        $this->payPalGateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->payPalGateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        if(env('PAYPAL_MODE') == 'sandbox'){
            $this->payPalGateway->setTestMode('false');
        }elseif(env('PAYPAL_MODE') == 'live'){
            $this->payPalGateway->setTestMode('true');
        }
    }


    public function payment($data)
    {
        $response = $this->payPalGateway->purchase(array(
            'amount' => $data['amount'],
            'currency' => 'USD',
            'returnUrl' => route('paypal.paypalSuccess'),
            'cancelUrl' => route('paypal.paypalFailed'),

        ))->send();

        if ($response->isRedirect()) {
            $response->redirect(); // this will automatically forward the customer
        } else {
            Toastr::error($response->getMessage(), 'Failed');
            return \redirect()->back();
        }
    }

    public function paypalSuccess(Request $request)
    {
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->payPalGateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();

            if ($response->isSuccessful()) {
                $arr_body = $response->getData();
                $paymentAmount = $arr_body['transactions'][0]['amount'];
                if (session()->has('wallet_recharge')) {
                    $return_data = $arr_body['id'];
                    $walletService = new WalletRepository;
                    return $walletService->walletRecharge($paymentAmount['total'], "3", $return_data);
                }
                if (session()->has('order_payment')) {
                    $return_data = $arr_body['id'];
                    $orderPaymentService = new OrderRepository;
                    $order_payment = $orderPaymentService->orderPaymentDone($paymentAmount['total'], "3", $return_data, (auth()->check())?auth()->user():null);
                    if($order_payment == 'failed'){
                        Toastr::error('Invalid Payment');
                        return redirect(url('/checkout'));
                    }
                    $payment_id = $order_payment->id;
                    Session()->forget('order_payment');
                    $data['payment_id'] = encrypt($payment_id);
                    $data['gateway_id'] = encrypt(3);
                    $data['step'] = 'complete_order';
                    LogActivity::successLog('Order payment successful.');
                    return redirect()->route('frontend.checkout', $data);
                }
                if (session()->has('subscription_payment')) {
                    $return_data = $arr_body['id'];
                    $tnx_check = SubsciptionPaymentInfo::where('txn_id', $return_data)->first();
                    if($tnx_check){
                        Toastr::error('Invalid Payment');

                    }else{
                        $defaultIncomeAccount = $this->defaultIncomeAccount();
                        $transactionRepo = new TransactionRepository(new Transaction);
                        $transaction = $transactionRepo->makeTransaction(auth()->user()->first_name." - Subsriction Payment", "in", "Paypal", "subscription_payment", $defaultIncomeAccount, "Subscription Payment", auth()->user()->SellerSubscriptions->latest()->first(), $paymentAmount['total'], Carbon::now()->format('Y-m-d'), auth()->id(), null, null);
                        auth()->user()->SellerSubscriptions->latest()->first()->update(['last_payment_date' => Carbon::now()->format('Y-m-d')]);
                        SubsciptionPaymentInfo::create([
                            'transaction_id' => $transaction->id,
                            'txn_id' => $return_data,
                        ]);
                        session()->forget('subscription_payment');
                        Toastr::success(__('common.payment_successfully'),__('common.success'));
                        LogActivity::successLog('Subscription payment successful.');
                    }
                    return redirect()->route('seller.dashboard');
                }
                return redirect()->back();

            } else {
                $msg = str_replace("'", " ", $response->getMessage());
                Toastr::error($msg, 'Failed');
                return redirect()->back();
            }
        }
    }

    public function paypalFailed()
    {
        return ('User is canceled the payment.');
    }

}
