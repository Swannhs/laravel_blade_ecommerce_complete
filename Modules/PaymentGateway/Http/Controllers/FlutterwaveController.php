<?php

namespace Modules\PaymentGateway\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\OrderRepository;
use Modules\Wallet\Repositories\WalletRepository;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Account\Repositories\TransactionRepository;
use Modules\Account\Entities\Transaction;
use Modules\FrontendCMS\Entities\SubsciptionPaymentInfo;
use App\Traits\Accounts;
use Carbon\Carbon;
use Modules\UserActivityLog\Traits\LogActivity;

class FlutterwaveController extends Controller
{
    use Accounts;

    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }  

    public function payment($data)
    {
        $reference = Flutterwave::generateReference();

        // Enter the details of the payment
        $data = [
            'payment_options' => 'card,banktransfer',
            'amount' => $data['amount'],
            'email' => $data['email'],
            'tx_ref' => $reference,
            'currency' => "NGN",
            'redirect_url' => route('flatterwave.callback'),
            'customer' => [
                'email' => $data['email'],
                "phonenumber" => $data['phone'],
                "name" => $data['name']
            ],

            "customizations" => [
                "title" => $data['purpose'],
                "description" => date('y-m-d')
            ]
        ];

        $payment = Flutterwave::initializePayment($data);


        if ($payment['status'] !== 'success') {
            Toastr::error(__('common.Something Went Wrong'));
            return redirect()->route('my-wallet.index', auth()->user()->role->type);
        }

        return redirect($payment['data']['link']);
    }

    public function callback()
    {
        try {
            $transactionID = Flutterwave::getTransactionIDFromCallback();
            $data = Flutterwave::verifyTransaction($transactionID);

            if ($data['status'] === "success") {
                if (session()->has('wallet_recharge')) {
                    $amount = $data['data']['amount'];
                    $response = $data['data']['tx_ref'];
                    $walletService = new WalletRepository;
                    return $walletService->walletRecharge($amount, "14", $response);
                    
                }
                if (session()->has('order_payment')) {
                    $amount = $data['data']['amount'];
                    $response = $data['data']['tx_ref'];
                    $orderPaymentService = new OrderRepository;
                    $order_payment = $orderPaymentService->orderPaymentDone($amount, "14", $response, (auth()->check())?auth()->user():null);
                    if($order_payment == 'failed'){
                        Toastr::error('Invalid Payment');
                        return redirect(url('/checkout'));
                    }
                    $payment_id = $order_payment->id;
                    session()->forget('order_payment');
                    $data['payment_id'] = encrypt($payment_id);
                    $data['gateway_id'] = encrypt(9);
                    LogActivity::successLog('Order payment successful.');
                    return redirect()->route('frontend.checkout', $data);
                }
                if (session()->has('subscription_payment')) {
                    $amount = $data['data']['amount'];
                    $response = $data['data']['tx_ref'];
                    $defaultIncomeAccount = $this->defaultIncomeAccount();
                    $transactionRepo = new TransactionRepository(new Transaction);
                    $transaction = $transactionRepo->makeTransaction(auth()->user()->first_name." - Subsriction Payment", "in", "Flutterwave", "subscription_payment", $defaultIncomeAccount, "Subscription Payment", auth()->user()->SellerSubscriptions->latest()->first(), $amount, Carbon::now()->format('Y-m-d'), auth()->id(), null, null);
                    auth()->user()->SellerSubscriptions->latest()->first()->update(['last_payment_date' => Carbon::now()->format('Y-m-d')]);
                    SubsciptionPaymentInfo::create([
                        'transaction_id' => $transaction->id,
                        'txn_id' => $response,
                    ]);
                    session()->forget('subscription_payment');
                    Toastr::success(__('common.payment_successfully'),__('common.success'));
                    LogActivity::successLog('Subscription payment successful.');
                    return redirect()->route('seller.dashboard');
                }
            }else {
                Toastr::error(__('common.operation_failed'));
                return redirect()->route('my-wallet.index', auth()->user()->role->type);
            }
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->route('frontend.welcome');
        }

    }
}
