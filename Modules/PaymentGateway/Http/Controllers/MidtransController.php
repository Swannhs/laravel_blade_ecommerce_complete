<?php

namespace Modules\PaymentGateway\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\OrderRepository;
use Modules\Wallet\Repositories\WalletRepository;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Account\Repositories\TransactionRepository;
use Modules\Account\Entities\Transaction;
use Modules\FrontendCMS\Entities\SubsciptionPaymentInfo;
use App\Traits\Accounts;
use Carbon\Carbon;

class MidtransController extends Controller
{
    use Accounts;

    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }  

    public function paymentProcess($data)
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('MIDTRANS_MERCHANT_KEY');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        if(env('MIDTRANS_ENVIRONMENT') == 'sandbox'){
            \Midtrans\Config::$isProduction = false;
        }
        elseif(env('MIDTRANS_ENVIRONMENT') == 'live'){
            \Midtrans\Config::$isProduction = true;
        }
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;


        try {

            if (session()->has('wallet_recharge')) {
                $walletService = new WalletRepository;
                $item = $walletService->walletRecharge($data['amount'], "10", $data['ref_no']);
                $params = array(
                    'transaction_details' => array(
                        'order_id' => $item->txn_id,
                        'gross_amount' => $data['amount'],
                    )
                );

                \LogActivity::successLog('Wallet recharge successful.');
            }
            if (session()->has('order_payment')) {
                $orderPaymentService = new OrderRepository;
                $item = $orderPaymentService->orderPaymentDone($data['amount'], "10", $data['ref_no'], (auth()->check())?auth()->user():null);
                $params = array(
                    'transaction_details' => array(
                        'order_id' => $item->id,
                        'gross_amount' => $data['amount'],
                    )
                );

                \LogActivity::successLog('Order payment successful.');
            }
            if (session()->has('subscription_payment')) {
                $orderPaymentService = new OrderRepository;
                $item = $orderPaymentService->orderPaymentDone($data['amount'], "10", $data['ref_no']);

                $defaultIncomeAccount = $this->defaultIncomeAccount();
                $transactionRepo = new TransactionRepository(new Transaction);
                $transaction = $transactionRepo->makeTransaction(auth()->user()->first_name." - Subsriction Payment", "in", "MidTrans", "subscription_payment", $defaultIncomeAccount, "Subscription Payment", auth()->user()->SellerSubscriptions->latest()->first(), $data['amount'], Carbon::now()->format('Y-m-d'), auth()->id(), null, null);

                $subscription_payment = SubsciptionPaymentInfo::create([
                    'transaction_id' => $transaction->id,
                    'txn_id' => $data['ref_no'],
                ]);
                $params = array(
                    'transaction_details' => array(
                        'order_id' => $subscription_payment->id,
                        'gross_amount' => $data['amount'],
                    )
                );

                \LogActivity::successLog('Subscription payment successful.');
            }




            $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;

            // Redirect to Snap Payment Page
            return redirect()->to($paymentUrl);
        }
        catch (Exception $e) {

            \LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->route('my-wallet.index', auth()->user()->role->type);
        }
    }

    public function paymentSuccess(Request $request)
    {
        if ($request->transaction_status == "settlement") {
            if (session()->has('wallet_recharge')) {
                Toastr::success(__('payment_gatways.recharge_successfully'),__('common.success'));

                \LogActivity::successLog('Wallet recharge successful.');
                return redirect()->route('my-wallet.index', auth()->user()->role->type);
            }
            if (session()->has('order_payment')) {
                $dat['payment_id'] = encrypt($request->order_id);
                $dat['gateway_id'] = encrypt(10);


                \LogActivity::successLog('Order payment successful.');
                return redirect()->route('frontend.checkout', $dat);
            }
            if (session()->has('subscription_payment')) {
                auth()->user()->SellerSubscriptions->latest()->first()->update(['last_payment_date' => Carbon::now()->format('Y-m-d')]);
                Toastr::success(__('common.payment_successfully'),__('common.success'));


                \LogActivity::successLog('Subscription payment successful.');
                return redirect()->route('seller.dashboard');
            }
        }
    }

    public function paymentFailed(Request $request)
    {
        if (session()->has('wallet_recharge')) {
            $walletService = new WalletRepository;
            $item = $walletService->delete($request->order_id);

            Toastr::error(__('common.operation_failed'));
            return redirect()->route('my-wallet.index', auth()->user()->role->type);
        }
        if (session()->has('order_payment')) {
            $amount =  $data->payment->amount;
            $response = $data->payment->payment_id;
            $orderPaymentService = new OrderRepository;
            $order_payment = $orderPaymentService->orderPaymentDelete($request->order_id);
            Toastr::error(__('common.operation_failed'));

            \LogActivity::successLog('Order payment failed.');
            return redirect()->route('frontend.checkout');
        }
        if (session()->has('subscription_payment')) {
            $subscription_info = SubsciptionPaymentInfo::findOrFail($request->order_id);

            $subscription_info->transaction->delete();
            $subscription_info->delete();
            Toastr::error(__('common.operation_failed'));

            \LogActivity::successLog('Subscription payment failed.');
            return redirect()->route('seller.dashboard');
        }
    }
}
