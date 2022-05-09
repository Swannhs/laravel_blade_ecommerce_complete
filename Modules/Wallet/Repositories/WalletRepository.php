<?php

namespace Modules\Wallet\Repositories;

use Modules\GeneralSetting\Entities\BusinessSetting;
use Modules\Account\Repositories\TransactionRepository;
use Modules\Wallet\Entities\WalletBalance;
use Modules\Account\Entities\Transaction;
use App\Models\User;
use App\Traits\Accounts;
use App\Traits\Notification;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Modules\GeneralSetting\Entities\EmailTemplateType;
use Modules\GeneralSetting\Entities\GeneralSetting;
use Modules\UserActivityLog\Traits\LogActivity;

class WalletRepository
{
    use Accounts, Notification;

    public function getAll()
    {
        if (auth()->user()->role->type != 'customer') {
            return WalletBalance::with('user')->where('user_id', auth()->user()->id)->latest();
        } else {
            return WalletBalance::with('user')->where('user_id', auth()->user()->id)->latest()->paginate(6);
        }
    }

    public function getAllUsers()
    {
        return User::whereIn('role_id', ['4', '5'])->latest()->get();
    }

    public function getAllRequests()
    {
        return WalletBalance::with('user', 'walletable')->where('type', 'Deposite')->latest();
    }

    public function getAllOfflineRecharge()
    {
        return WalletBalance::with('user', 'walletable')->where('txn_id', 'Added By Admin')->latest();
    }

    public function gateways()
    {
        return BusinessSetting::where('category_type', 'payment_gateways')->where('status', 1)->get();
    }

    public function walletRecharge($amount, $method, $response)
    {
        if($method != 1 || $method != 2 || $method != 7){
            $old_tnx = WalletBalance::where('txn_id', $response)->first();
            if($old_tnx){
                Toastr::error('Invalid Payment');
                return redirect()->route('my-wallet.index', auth()->user()->role->type);
            }else{
                $wallet_deposit = WalletBalance::create([
                    'user_id' => auth()->user()->id,
                    'type' => "Deposite",
                    'amount' => $amount,
                    'payment_method' => $method,
                    'txn_id' => $response,
                ]);
        
                if($method != 'BankPayment' && app('general_setting')->auto_approve_wallet_status == 1){
                    $wallet_deposit->update([
                        'status' => 1
                    ]);
                }
                LogActivity::successLog('Wallet recharge successful.');
                return redirect()->route('my-wallet.index', auth()->user()->role->type);
            }
        }
        $wallet_deposit = WalletBalance::create([
            'user_id' => auth()->user()->id,
            'type' => "Deposite",
            'amount' => $amount,
            'payment_method' => $method,
            'txn_id' => $response,
        ]);

        if($method != 'BankPayment' && app('general_setting')->auto_approve_wallet_status == 1){
            $wallet_deposit->update([
                'status' => 1
            ]);
        }
        LogActivity::successLog('Wallet recharge successful.');
        return redirect()->route('my-wallet.index', auth()->user()->role->type);
    }

    public function walletOfflineRecharge($data)
    {
        $wallet_deposit = WalletBalance::create([
            'user_id' => $data['user_id'],
            'type' => "Deposite",
            'amount' => $data['recharge_amount'],
            'payment_method' => $data['payment_method'],
            'txn_id' => "Added By Admin",
            'status' => 1,
        ]);
        $defaultIncomeAccount = $this->defaultIncomeAccount();


        $user = User::findOrFail($data['user_id']);

        $notificationUrl = route('my-wallet.index',['subject' =>  $user->role->type]);
        $this->notificationUrl = $notificationUrl;
        $this->typeId = EmailTemplateType::where('type','wallet_email_template')->first()->id;
        $this->notificationSend("Offline recharge", $data['user_id']);

        $transactionRepo = new TransactionRepository(new Transaction);
        $transactionRepo->makeTransaction("Wallet Recharge by offline", "in", $wallet_deposit->GatewayName, "wallet_recharge", $defaultIncomeAccount, "Wallet Recharge by customer", $wallet_deposit, $wallet_deposit->amount, Carbon::now()->format('Y-m-d'), auth()->id(), null, null);
        return $wallet_deposit;
    }

    public function walletOfflineRechargeUpdate($data)
    {
        $wallet_deposit = WalletBalance::findOrFail($data['id'])->update([
            'user_id' => $data['user_id'],
            'amount' => $data['recharge_amount'],
            'payment_method' => $data['payment_method'],
            'txn_id' => "Added By Admin",
        ]);
    }

    public function cartPaymentData($order_id, $total_amount, $type, $customer_id, $user_type)
    {
        $wallet_cart_payment = WalletBalance::create([
            'walletable_id' => $order_id,
            'walletable_type' => 'App\Models\Order',
            'user_type' => $user_type,
            'user_id' => $customer_id,
            'type' => $type,
            'amount' => $total_amount,
            'payment_method' => 2,
            'txn_id' => "None",
            'status' => 1
        ]);
    }

    public function find($id)
    {
        return WalletBalance::findOrFail($id);
    }

    public function walletSalePaymentAdd($order_id, $total_amount, $type, $seller_id)
    {
        $wallet_cart_payment = WalletBalance::create([
            'walletable_id' => $order_id,
            'walletable_type' => 'App\Models\Order',
            'user_id' => $seller_id,
            'type' => $type,
            'amount' => $total_amount,
            'payment_method' => 2,
            'txn_id' => "None",
            'status' => 1,
        ]);
    }

    public function walletRefundPaymentTransaction($refund_id, $refund_infos, $customer_id)
    {
        foreach ($refund_infos as $key => $refund_info) {
            $item = explode('-', $refund_info);
            $seller_id = $item[0];
            $amount = $item[1];
            $type = $item[2];
            WalletBalance::create([
                'walletable_id' => $refund_id,
                'walletable_type' => 'Modules\Refund\Entities\RefundRequest',
                'user_id' => $seller_id,
                'type' => $type,
                'amount' => $amount,
                'payment_method' => 2,
                'txn_id' => "None",
                'status' => 1,
            ]);
            if ($customer_id != null) {
                WalletBalance::create([
                    'walletable_id' => $refund_id,
                    'walletable_type' => 'Modules\Refund\Entities\RefundRequest',
                    'user_id' => $customer_id,
                    'type' => 'Refund Back',
                    'amount' => $amount,
                    'payment_method' => 2,
                    'txn_id' => "None",
                    'status' => 1,
                ]);
            }
        }
    }

    public function withdrawRequestStore($data)
    {
        WalletBalance::create([
            'user_id' => auth()->user()->id,
            'type' => 'Withdraw',
            'amount' => $data['amount'],
            'payment_method' => 2,
            'txn_id' => "None",
            'status' => 1,
        ]);
    }

    public function update(array $data, $id)
    {
        //
    }

    public function delete($id)
    {
        return WalletBalance::where('txn_id', $id)->first()->delete();
    }

    public function getWalletConfiguration()
    {
        return GeneralSetting::first();
    }

    public function walletConfigurationUpdate($request)
    {
        $generatlSetting = GeneralSetting::first();
        $generatlSetting->auto_approve_wallet_status = $request->status;
        $generatlSetting->save();

    }
}
