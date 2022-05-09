<?php

namespace Modules\Wallet\Repositories;
use Modules\Wallet\Entities\WalletBalance;
use Modules\Account\Repositories\TransactionRepository;
use Modules\Account\Entities\Transaction;
use App\Models\User;
use App\Traits\SendMail;
use App\Traits\Accounts;
use App\Traits\Notification;
use Carbon\Carbon;
use Modules\GeneralSetting\Entities\EmailTemplateType;

class WithdrawRequestRepository
{
    use SendMail, Accounts,Notification;

    public function getAll()
    {
        return WalletBalance::with('user','user.SellerBankAccount')->where('type', 'Withdraw')->latest();
    }

    public function getMyAll()
    {
        return WalletBalance::with('user')->where('user_id', auth()->user()->id)->where('type', 'Withdraw')->latest();
    }

    public function findWidrawRequestById($id){
        return WalletBalance::findOrFail($id);
    }

    public function withdrawRequestStore($data)
    {
        WalletBalance::create([
            'user_id' => auth()->user()->id,
            'type' => 'Withdraw',
            'amount' => $data['amount'],
            'payment_method' => 7,
            'txn_id' => "None",
            'status' => 0,
        ]);

         // Send Notification
         $this->notificationUrl = route('wallet.withdraw_requests');
         $this->typeId = EmailTemplateType::where('type', 'withdraw_request_email_template')->first()->id;
         $user1 = User::where('role_id',1)->first();
         $user2 = User::where('role_id',2)->first();
         $this->notificationSend("Seller payout Request", $user1->id);
         $this->notificationSend("Seller payout Request", $user2->id);
    }

    public function withdrawRequestUpdate(array $data)
    {
        WalletBalance::findOrFail($data['id'])->update([
            'amount' => $data['amount'],
        ]);
    }

    public function withdrawRequestStatusUpdate($data, $id)
    {
        $wallet_balance = WalletBalance::findOrFail($id);
        $wallet_balance->update([
            'status' => $data['status'],
        ]);
        $notificationUrl = route('my-wallet.withdraw_index');
        $this->notificationUrl = $notificationUrl;
        $this->typeId = EmailTemplateType::where('type','wallet_email_template')->first()->id;//wallet email templete typeId
        if ($data['status'] == 1) {
            $transactionRepo = new TransactionRepository(new Transaction);
            $defaultSellerAccount = $this->defaultSellerAccount();
            $transactionRepo->makeTransaction("Money Withdraw By Seller", "out", $wallet_balance->GatewayName, "sales_expense", $defaultSellerAccount, "Product Sale GST", $wallet_balance, $wallet_balance->amount, Carbon::now()->format('Y-m-d'), auth()->id(), null, null);

            $this->notificationSend("Withdraw request approve",$wallet_balance->user_id);
        }else{
            $this->notificationSend("Withdraw request declined",$wallet_balance->user_id);
        }
    }

    public function delete($id)
    {
        //
    }
}
