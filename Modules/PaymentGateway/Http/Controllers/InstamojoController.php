<?php

namespace Modules\PaymentGateway\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\OrderRepository;
use Modules\Wallet\Repositories\WalletRepository;
use PaytmWallet;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Account\Repositories\TransactionRepository;
use Modules\Account\Entities\Transaction;
use Modules\FrontendCMS\Entities\SubsciptionPaymentInfo;
use App\Traits\Accounts;
use Carbon\Carbon;
use Modules\UserActivityLog\Traits\LogActivity;

class InstamojoController extends Controller
{
    use Accounts;

    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }  

    public function paymentProcess($data)
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, env('IM_URL') . '/payment-requests/');
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    "X-Api-Key:" . env('IM_API_KEY'),
                    "X-Auth-Token:" . env('IM_AUTH_TOKEN')
                )
            );
            $payload = array(
                'purpose' => 'NiceSnippets',
                'amount' => $data['amount'],
                'phone' => $data['mobile'],
                'buyer_name' => $data['name'],
                'redirect_url' => route('instamojo.payment_success'),
                'send_email' => true,
                'webhook' => '',
                'send_sms' => true,
                'email' => $data['email'],
                'allow_repeated_payments' => false
            );
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response);

            return redirect($response->payment_request->longurl);
        } catch (\Exception $e) {

            \LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->route('my-wallet.index', auth()->user()->role->type);
        }
    }

    public function paymentSuccess(Request $request)
    {
        $input = $request->all();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, env('IM_URL') . '/payments/' . $request->get('payment_id'));
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                "X-Api-Key:" . env('IM_API_KEY'),
                "X-Auth-Token:" . env('IM_AUTH_TOKEN')
            )
        );

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            Toastr::error(__('common.operation_failed'));
            return redirect()->route('my-wallet.index', auth()->user()->role->type);
        } else {
            $data = json_decode($response);
        }

        if ($data->success == true) {
            if ($data->payment->status == "Credit") {
                if (session()->has('wallet_recharge')) {
                    $amount =  $data->payment->amount;
                    $response = $data->payment->payment_id;
                    $walletService = new WalletRepository;
                    session()->forget('wallet_recharge');
                    return $walletService->walletRecharge($amount, "8", $response);
                }
                if (session()->has('order_payment')) {
                    $amount =  $data->payment->amount;
                    $response = $data->payment->payment_id;
                    $orderPaymentService = new OrderRepository;
                    $order_payment = $orderPaymentService->orderPaymentDone($amount, "8", $response, (auth()->check()) ? auth()->user() : null);
                    if($order_payment == 'failed'){
                        Toastr::error('Invalid Payment');
                        return redirect(url('/checkout'));
                    }
                    $payment_id = $order_payment['id'];
                    session()->forget('order_payment');
                    $data['payment_id'] = encrypt($payment_id);
                    $data['gateway_id'] = encrypt(8);
                    $data['step'] = 'complete_order';
                    LogActivity::successLog('Order payment successful.');
                    return redirect()->route('frontend.checkout', $data);
                }
                if (session()->has('subscription_payment')) {
                    $amount =  $data->payment->amount;
                    $response = $data->payment->payment_id;
                    $defaultIncomeAccount = $this->defaultIncomeAccount();
                    $transactionRepo = new TransactionRepository(new Transaction);
                    $transaction = $transactionRepo->makeTransaction(auth()->user()->first_name . " - Subsriction Payment", "in", "InstaMojo", "subscription_payment", $defaultIncomeAccount, "Subscription Payment", auth()->user()->SellerSubscriptions->latest()->first(), $amount, Carbon::now()->format('Y-m-d'), auth()->id(), null, null);
                    auth()->user()->SellerSubscriptions->latest()->first()->update(['last_payment_date' => Carbon::now()->format('Y-m-d')]);
                    SubsciptionPaymentInfo::create([
                        'transaction_id' => $transaction->id,
                        'txn_id' => $response,
                    ]);
                    session()->forget('subscription_payment');
                    Toastr::success(__('common.paymeny_successfully'), __('common.success'));
                    LogActivity::successLog('Subscription payment successful.');
                    return redirect()->route('seller.dashboard');
                }
            }
        } else {
            if (session()->has('subscription_payment')) {
                session()->forget('subscription_payment');
                Toastr::error(__('common.operation_failed'));
                return redirect()->route('seller.dashboard');
            }
            Toastr::error(__('common.operation_failed'));
            return redirect()->route('frontend.welcome');
        }
    }
}
