<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RecentViewProduct;

class ResetRecentViewedProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:reset_recent_viewed_product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recently Viewed Product Delete after certain period';

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
        $num_of_days = app('recently_viewed_config')['number_of_days'];
        $recentViewedProducts = RecentViewProduct::where('viewed_at', '<=', \Carbon\Carbon::now()->subDays($num_of_days)->format('y-m-d'))->get();
        foreach ($recentViewedProducts as $key => $recentViewedProduct) {
            $recentViewedProduct->delete();
        }
    }
}
