<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Session;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\Marketing\Entities\FlashDeal;
use App\Models\Cart;

class ResetCartPriceForFlashDeal extends Command
{

    protected $signature = 'command:reset_cart_price';


    protected $description = 'Command for cart price reset according to flash deal end.';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $date = date('Y-m-d');
        $flash_deal = FlashDeal::where('status', 1)->where('start_date', '<=',$date)->where('end_date','>=',$date)->first();
        if(!$flash_deal){
            if(Session::has('cart')){
                $cart = collect();

                foreach(Session::get('cart') as $cartItem){
                    $seller_product_sku = SellerProductSKU::findOrFail($cartItem['product_id']);
                    $seller_product = $seller_product_sku->product;

                    $price = 0;

                    if(date('Y-m-d',strtotime($seller_product->discount_start_date))<= $date && date('Y-m-d',strtotime($seller_product->discount_end_date))>= $date){
                        $price = selling_price($seller_product_sku->selling_price,$seller_product->discount_type,$seller_product->discount);
                    }else{
                        $price = $seller_product_sku->selling_price;
                    }

                    $cartItem['price'] = $price;
                    $cartItem['total_price'] = $price * $cartItem['qty'];

                    $cart->push($cartItem);

                    Session::put('cart', $cart);
                }
            }

            $cartData = Cart::all();
            if($cartData){
                foreach($cartData as $key => $cartItem){
                    $seller_product_sku = SellerProductSKU::findOrFail($cartItem->product_id);
                    $seller_product = $seller_product_sku->product;

                    $price = 0;

                    if(date('Y-m-d',strtotime($seller_product->discount_start_date))<= $date && date('Y-m-d',strtotime($seller_product->discount_end_date))>= $date){
                        $price = selling_price($seller_product_sku->selling_price,$seller_product->discount_type,$seller_product->discount);
                    }else{
                        $price = $seller_product_sku->selling_price;
                    }

                    $cartItem->update([
                        'price' => $price,
                        'total_price' => $price * $cartItem->qty
                    ]);
                }
            }
            return $cartData;


        }else{

            if(Session::has('cart')){
                $cart = collect();

                foreach(Session::get('cart') as $cartItem){
                    $seller_product_sku = SellerProductSKU::findOrFail($cartItem['product_id']);
                    $seller_product = $seller_product_sku->product;

                    $price = selling_price($seller_product_sku->selling_price,$seller_product->hasDeal()->discount_type,$seller_product->hasDeal()->discount);

                    $cartItem['price'] = $price;
                    $cartItem['total_price'] = $price * $cartItem['qty'];

                    $cart->push($cartItem);

                    Session::put('cart', $cart);
                }
            }

            $cartData = Cart::all();
            if($cartData){
                foreach($cartData as $key => $cartItem){

                    $seller_product_sku = SellerProductSKU::findOrFail($cartItem->product_id);
                    $seller_product = $seller_product_sku->product;

                    $price = selling_price($seller_product_sku->selling_price,$seller_product->hasDeal()->discount_type,$seller_product->hasDeal()->discount);

                    $cartItem->update([
                        'price' => $price,
                        'total_price' => $price * $cartItem->qty
                    ]);
                }
            }
            return $cartData;
        }
    }
}
