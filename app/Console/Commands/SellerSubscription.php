<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\MultiVendor\Entities\SellerAccount;
use App\Models\User;
use Carbon\Carbon;

class SellerSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sellerSubscription:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $seller_ids = SellerAccount::where('seller_commission_id',3)->pluck('user_id');
        $sellers = User::whereIn('id', $seller_ids)->with('SellerAccount', 'SellerSubscriptions')->get();
        foreach ($sellers as $seller) {
            if ($seller->SellerAccount->subscription_type == "monthly") {
                if (Carbon::now()->subDays(30)->format('y-m-d') > $seller->SellerSubscriptions->last_payment_date) {
                    $seller->SellerSubscriptions->update(['is_paid' => 0]);
                }
            }else {
                if (Carbon::now()->subDays(365)->format('y-m-d') > $seller->SellerSubscriptions->last_payment_date) {
                    $seller->SellerSubscriptions->update(['is_paid' => 0]);
                }
            }
        }
        return true;
    }
}
