<?php

namespace Modules\OrderManage\Repositories;

use App\Models\Order;
use App\Models\User;
use App\Models\OrderPackageDetail;
use App\Models\OrderProductDetail;
use App\Models\OrderPayment;
use App\Models\DigitalFileDownload;
use Modules\Product\Entities\DigitalFile;
use Modules\OrderManage\Entities\OrderDeliveryState;
use Modules\Account\Repositories\TransactionRepository;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\MultiVendor\Repositories\MerchantRepository;
use Modules\Account\Entities\Transaction;
use App\Traits\SendMail;
use App\Traits\Accounts;
use App\Traits\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\GeneralSetting\Entities\EmailTemplateType;
use Modules\GeneralSetting\Entities\GeneralSetting;
use Modules\OrderManage\Entities\CustomerNotification;

class OrderManageRepository
{
    use SendMail, Accounts, Notification;

    public function myConfirmedSalesList()
    {
        $seller_id = getParentSellerId();
        return OrderPackageDetail::whereHas('order', function ($q) {
            $q->where('is_cancelled', 0)->where('is_confirmed', 1);
        })->where('is_cancelled', 0)->with('order', 'seller', 'order.customer')->where('seller_id', $seller_id)->latest();
    }

    public function myCompletedSalesList()
    {
        $seller_id = getParentSellerId();
        return OrderPackageDetail::whereHas('order', function ($q) {
            $q->where('is_cancelled', 0)->where('is_completed', 1);
        })->where('is_cancelled', 0)->with('order', 'seller', 'order.customer')->where('seller_id', $seller_id)->latest();
    }

    public function myPendingPaymentSalesList()
    {
        $seller_id = getParentSellerId();
        return OrderPackageDetail::whereHas('order', function ($q) {
            $q->where('is_cancelled', 0)->where('is_paid', 0);
        })->where('is_cancelled', 0)->with('order', 'seller', 'order.customer')->where('seller_id', $seller_id)->latest();
    }

    public function myCancelledPaymentSalesList()
    {
        $seller_id = getParentSellerId();
        $orderpackage =  OrderPackageDetail::where('seller_id', $seller_id)
        ->whereHas('order', function ($q) {
                $q->where('is_cancelled', 1);
            })->orWhere('is_cancelled', 1)
        ->with('order', 'seller', 'order.customer')->latest();

        return $orderpackage->where('seller_id', $seller_id);
    }

    public function totalSalesList()
    {
        return Order::with('packages', 'customer')->latest();
    }

    public function findOrderByID($id)
    {
        return Order::findOrFail($id);
    }

    public function orderInfoUpdate($data, $id)
    {
        $order = $this->findOrderByID($id);
        $defaultIncomeAccount = $this->defaultIncomeAccount();
        $defaultGSTAccount = $this->defaultGSTAccount();
        $defaultSellerAccount = $this->defaultSellerAccount();
        $defaultProductTaxAccount = $this->defaultProductTaxAccount();
        if ($defaultIncomeAccount == null || $defaultGSTAccount == null || $defaultSellerAccount == null || $defaultProductTaxAccount == null) {
            return false;
        }
        $total_seller_amount = 0;
        $total_gst_amount = 0;
        $total_product_tax_amount = 0;
        $revenue_amount = 0;
        $total_package_amount = 0;
        $total_sale_qty = 0;

        if ($order->is_confirmed == 0 && $data['is_confirmed'] == 1) {
            foreach ($order->packages as $key => $package) {
                if ($package->is_cancelled == 0) {

                    if ($package->seller->role->type != "superadmin") {
                        $amount = $this->get_commission_rate($package->seller_id, $package);
                        $seller_amount = $amount['seller_rcv_money'] + $package->tax_amount;
                        $revenue_amount += $amount['final_commission'];
                        if ($amount['claim_gst'] == 0) {
                            $total_gst_amount += $package->gst_taxes->sum('amount');
                        } else {
                            $seller_amount += $package->gst_taxes->sum('amount');
                            $package->update(['gst_claimed' => 1]);
                        }
                        $total_seller_amount += $seller_amount;
                        $wallet_service = new WalletRepository;
                        $wallet_service->walletSalePaymentAdd($order->id, $seller_amount, "Sale Payment", $package->seller_id);
                    } else {
                        if(isModuleActive('MultiVendor')){
                            $total_sale_qty = $package->seller->SellerAccount->total_sale + $package->number_of_product;
                            $package->seller->SellerAccount->update(['total_sale_qty' => $total_sale_qty]);
                            $revenue_amount += $package->products->sum('total_price');
                            $total_gst_amount += $package->gst_taxes->sum('amount');
                            $total_product_tax_amount += $package->tax_amount;
                        }
                    }
                } else {
                    if (file_exists(base_path() . '/Modules/GST/') && (app('gst_config')['enable_gst'] == "gst" || app('gst_config')['enable_gst'] == "flat_tax")) {
                        $package_price = $package->products->sum('total_price') + $package->shipping_cost + $package->tax_amount + $package->gst_taxes->sum('amount');
                    } else {
                        $package_price = $package->products->sum('total_price') + $package->shipping_cost + $package->tax_amount;
                    }
                    $total_package_amount += $package_price;
                }

                OrderDeliveryState::create([
                    'order_package_id' => $package->id,
                    'delivery_status' => 2,
                    'note' => 'Order is under processing.',
                    'created_by' => auth()->user()->id,
                    'date' => Carbon::now()->format('Y-m-d')
                ]);
            }

            $transactionRepo = new TransactionRepository(new Transaction);

            $transactionRepo->makeTransaction("Product Selling Amount for Seller", "in", $order->GatewayName, "sales_expense", $defaultSellerAccount, "Product Selling Amount for Seller", $order, $total_seller_amount, Carbon::now()->format('Y-m-d'), auth()->id(), null, null);

            $transactionRepo->makeTransaction("Earning from Sales", "in", $order->GatewayName, "sales_income", $defaultIncomeAccount, "Product Sale", $order, $revenue_amount, Carbon::now()->format('Y-m-d'), auth()->id(), null, null);
            if ($total_gst_amount > 0) {
                $transactionRepo->makeTransaction("GST on Sales", "in", $order->GatewayName, "gst_tsx", $defaultGSTAccount, "GST on Product Sale In", $order, $total_gst_amount, Carbon::now()->format('Y-m-d'), auth()->id(), null, null);
            }
            if ($total_product_tax_amount > 0) {
                $transactionRepo->makeTransaction("Product Tax on Sale", "in", $order->GatewayName, "product_tax", $defaultProductTaxAccount, "ProductWise Tax Inhouse", $order, $total_product_tax_amount, Carbon::now()->format('Y-m-d'), auth()->id(), null, null);
            }

            //customer and seller get Notification When super admin change any delivery status
            $notificationUrl = route('frontend.my_purchase_order_detail',encrypt($order->id));
            $this->notificationUrl = $notificationUrl;
            $this->typeId = EmailTemplateType::where('type','order_email_template')->first()->id;//order email templete type id
            $this->notificationSend("Order confirmation", $order->customer_id);

        }

        if ($data['is_confirmed'] == 2) {
            $order->update([
                'is_cancelled' => 1
            ]);
        }

        if ($order->is_paid != $data['is_paid']) {
            if (app('business_settings')->where('type', 'mail_notification')->first()->status == 1) {
                try {
                    switch ($data['is_paid']) {
                        case 1:
                            $this->sendOrderRefundInfoUpdateMail($order, 5);
                            break;
                        default:
                            break;
                    }
                } catch (\Exception $e) {
                }
            }
        }
        if ($order->is_confirmed != $data['is_confirmed']) {
            if (app('business_settings')->where('type', 'mail_notification')->first()->status == 1) {
                switch ($data['is_confirmed']) {
                    case 0:
                        $this->sendOrderRefundInfoUpdateMail($order, 2);
                        break;
                    case 1:
                        $this->sendOrderRefundInfoUpdateMail($order, 3);
                        break;
                    case 2:
                        $this->sendOrderRefundInfoUpdateMail($order, 4);
                        break;
                    default:
                        break;
                }
            }
        }
        if ($order->is_completed != $data['is_completed']) {
            if (app('business_settings')->where('type', 'mail_notification')->first()->status == 1) {
                switch ($data['is_completed']) {
                    case 1:
                        $this->sendOrderRefundInfoUpdateMail($order, 6);
                        $this->sendOrderRefundInfoUpdateMail($order, 16);
                        break;
                    default:
                        break;
                }
            }
        }

        if ($order->is_confirmed == 0 && $data['is_confirmed'] == 1) {
            foreach ($order->packages as $key => $package) {
                $this->updateStock($package);
                $package->update([
                    'delivery_status' => 2
                ]);
            }
        }

        $order->update([
            'is_paid' => $data['is_paid'],
            'is_confirmed' => $data['is_confirmed'],
            'is_completed' => $data['is_completed'],
        ]);

        return true;
    }

    public function get_commission_rate($seller_id, $package)
    {
        $merchantRepo = new MerchantRepository();
        $seller = $merchantRepo->findUserByID($package->seller_id);
        if ($seller) {
            $seller_account = $seller->SellerAccount;
            $seller_business_info = $seller->SellerBusinessInformation;
            $claim_gst = $seller_business_info->claim_gst;
            if ($seller_account->seller_commission_id == 1) {
                $total_amount_of_package = $package->products->sum('total_price');

                $commission_rate = $seller_account->commission_rate;
                $final_commission = ($commission_rate * $total_amount_of_package) / 100;
                $seller_rcv_money = $total_amount_of_package - $final_commission;
            }

            // category_wise_calculation baki
            if ($seller_account->seller_commission_id == 2) {
                $final_commission = 0;
                $order_products = OrderProductDetail::with('seller_product_sku', 'seller_product_sku.sku', 'seller_product_sku.sku.product', 'seller_product_sku.sku.product.categories')->where('package_id', $package->id)->get();
                foreach ($order_products as $key => $order_product) {

                    $commission_rate = 0;
                    if(app('general_setting')->commission_by == 1){
                        $commission_rate = $order_product->seller_product_sku->sku->product->categories->min('commission_rate');
                    }
                    elseif(app('general_setting')->commission_by == 2){
                        $commission_rate = $order_product->seller_product_sku->sku->product->categories->max('commission_rate');
                    }
                    elseif(app('general_setting')->commission_by == 3){
                        $commission_rate = $order_product->seller_product_sku->sku->product->categories->avg('commission_rate');
                    }

                    if ($commission_rate > 0) {
                        $commission_amount = ($commission_rate * $order_product->seller_product_sku->selling_price) / 100;
                        $final_commission += $commission_amount;
                    } else {
                        $commission_rate = $order_product->seller_product_sku->sku->product->category->parentCategory->commission_rate;
                        $commission_amount = ($commission_rate * $order_product->seller_product_sku->selling_price) / 100;
                        $final_commission += $commission_amount;
                    }
                }
                $seller_rcv_money = $package->products->sum('total_price') - $final_commission;
            }

            // Subscription Package wise transaction fee
            if ($seller_account->seller_commission_id == 3) {
                if ($seller->SellerSubscriptions->pricing->transaction_fee > 0) {
                    $total_amount_of_package = $package->products->sum('total_price');

                    $commission_rate = $seller->SellerSubscriptions->pricing->transaction_fee;
                    $final_commission = ($commission_rate * $total_amount_of_package) / 100;
                    $seller_rcv_money = $total_amount_of_package - $final_commission;
                } else {
                    $final_commission = 0;
                    $seller_rcv_money = $package->products->sum('total_price');
                }
            }
            $data['seller_rcv_money'] = $seller_rcv_money;
            $data['claim_gst'] = $claim_gst;
            $data['final_commission'] = $final_commission;


            return $data;
        }
    }

    public function findOrderPackageByID($id)
    {
        return OrderPackageDetail::findOrFail($id);
    }

    public function updateDeliveryStatus($data, $id)
    {
        $order_package = $this->findOrderPackageByID($id);
        $order = $this->findOrderByID($order_package->order_id);
        if ($order->order_status != $data['delivery_status']) {
            if (app('business_settings')->where('type', 'mail_notification')->first()->status == 1) {
                $this->sendOrderRefundorDeliveryProcessMail($order, "Modules\OrderManage\Entities\DeliveryProcess", $data['delivery_status']);
            }
            // Notification : when status changed
            $notificationUrl = route('frontend.my_purchase_order_detail',encrypt($order->id));
            $this->notificationUrl = $notificationUrl;
            $this->typeId = EmailTemplateType::where('type','order_email_template')->first()->id;//order email templete type id
            $this->notificationSend($data['delivery_status'], $order->customer_id);
        }
        $order->update([
            'order_status' => $data['delivery_status'],
        ]);
        $order_package->update([
            'delivery_status' => $data['delivery_status'],
            'last_updated_by' => getParentSellerId(),
        ]);
        OrderDeliveryState::create([
            'order_package_id' => $order_package->id,
            'delivery_status' => $data['delivery_status'],
            'note' => $data['note'],
            'created_by' => getParentSellerId(),
            'date' => Carbon::now()->format('Y-m-d')
        ]);
    }

    public function updateDeliveryStatusRecieve($data)
    {
        $order_package = $this->findOrderPackageByID($data);
        $order = $this->findOrderByID($order_package->order_id);
        $order->update([
            'order_status' => 4,
        ]);
        $order_package->update([
            'delivery_status' => 4,
        ]);
        OrderDeliveryState::create([
            'order_package_id' => $order_package->id,
            'delivery_status' => 4,
            'note' => "Order Has been Recieved",
            'date' => Carbon::now()->format('Y-m-d')
        ]);
    }

    public function updateStock($orderpackage)
    {
        foreach ($orderpackage->products as $key => $package_product) {
            $stock = $package_product->seller_product_sku->product_stock;
            if ($package_product->seller_product_sku->product->stock_manage == 1) {
                $package_product->seller_product_sku->update([
                    'product_stock' => $stock - $package_product->qty,
                ]);
                if(@$package_product->package->seller->role->type == 'superadmin'){
                    $package_product->seller_product_sku->sku->update([
                        'product_stock' => $stock - $package_product->qty
                    ]);
                }
                
            }
        }
    }

    public function sendDigitalFileAccess($data)
    {
        $exists = DigitalFileDownload::where('package_id', $data['package_id'])->where('product_sku_id', $data['product_sku_id'])->where('seller_product_sku_id', $data['seller_product_sku_id'])->first();
        if (!$exists) {
            $digital_download = DigitalFileDownload::create([
                'customer_id' => (!empty('customer_id')) ? $data['customer_id'] : null,
                'seller_id' => $data['seller_id'],
                'order_id' => $data['order_id'],
                'package_id' => $data['package_id'],
                'seller_product_sku_id' => $data['seller_product_sku_id'],
                'product_sku_id' => $data['product_sku_id'],
                'download_limit' => $data['qty'] * 3,
            ]);
        }
        try {
            $file = DigitalFile::where('product_sku_id', $data['product_sku_id'])->first();
            $this->sendDigitalFileMail($data['mail'], route('digital_file_download', encrypt($digital_download->id)));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function DigitalFileDownload($slug)
    {
        $file = DigitalFileDownload::findOrFail(decrypt($slug));
        $part = explode('/', $file->file->file_source);
        $filePath = asset($file->file->file_source);
        $fileName = $part[3];
        $file->update([
            'downloaded_count' => $file->downloaded_count + 1,
        ]);
        if ($file->downloaded_count <= $file->download_limit) {
            return $filePath;
        } else {
            return asset('');
        }
    }

    public function orderConfirm($id){
        $order = Order::find($id);
        if($order){
            $order->update([
                'is_confirmed' => 1
            ]);

            foreach($order->packages as $key => $package){
                $package->update([
                    'delivery_status' => 2
                ]);
                $this->updateStock($package);
            }
            return 'done';
        }else{
            return 'failed';
        }

    }

    public function getTrackOrderConfiguration()
    {
        return GeneralSetting::first();
    }

    public function trackOrderConfigurationUpdate($request)
    {
        $generatlSetting = GeneralSetting::first();
        $generatlSetting->track_order_by_secret_id = $request->track_order_by_secret_id;
        $generatlSetting->save();
    }

    public function getPackageInfo($id){
        return OrderPackageDetail::find($id);
    }

}
