<?php
namespace Modules\Marketing\Repositories;

use Modules\Marketing\Entities\FlashDeal;
use Modules\Marketing\Entities\FlashDealProduct;
use \Modules\Marketing\Entities\FooterSetting;
use Modules\Seller\Entities\SellerProduct;
use Str;
use Carbon\Carbon;
class FlashDealsRepository {


    public function getAll(){
        $user = auth()->user();
        if($user->role->type == 'superadmin' || $user->role->type == 'admin' || $user->role->type == 'staff'){
            return FlashDeal::all();
        }
        elseif($user->role->type == 'seller'){
            return FlashDeal::where('created_by',$user->id)->get();
        }else{
            return [];
        }

    }

    public function store($data){
        $flash_deal = FlashDeal::create([
            'title' => $data['title'],
            'background_color' => $data['background_color'],
            'text_color' => $data['text_color'],
            'start_date' => Carbon::parse($data['start_date'])->format('Y-m-d'),
            'end_date' => Carbon::parse($data['end_date'])->format('Y-m-d'),
            'slug' => strtolower(str_replace(' ', '-', $data['title']).'-'.Str::random(5)),
            'banner_image' => $data['banner_image']
        ]);
        if($flash_deal){
            foreach($data['products'] as $key => $product){
                FlashDealProduct::create([
                    'flash_deal_id' => $flash_deal->id,
                    'seller_product_id' => $product,
                    'discount' => $data['discount'][$key],
                    'discount_type' => $data['discount_type'][$key]
                ]);
            }
        }

    }

    public function update($data, $id){
        $flash_deal = FlashDeal::findOrFail($id)->update([
            'title' => $data['title'],
            'background_color' => $data['background_color'],
            'text_color' => $data['text_color'],
            'start_date' => Carbon::parse($data['start_date'])->format('Y-m-d'),
            'end_date' => Carbon::parse($data['end_date'])->format('Y-m-d'),
            'banner_image' => $data['banner_image']
        ]);
        if($flash_deal){

            $old_products = FlashDealProduct::where('flash_deal_id',$id)->whereNotIn('seller_product_id',$data['products'])->pluck('id');
            FlashDealProduct::destroy($old_products);

            foreach($data['products'] as $key => $product){
                $deal = FlashDealProduct::where('flash_deal_id',$id)->where('seller_product_id',$product)->first();
                if($deal != null){
                    $deal->update([
                        'flash_deal_id' => $id,
                        'seller_product_id' => $product,
                        'discount' => $data['discount'][$key],
                        'discount_type' => $data['discount_type'][$key]
                    ]);
                }else{
                    FlashDealProduct::create([
                        'flash_deal_id' => $id,
                        'seller_product_id' => $product,
                        'discount' => $data['discount'][$key],
                        'discount_type' => $data['discount_type'][$key]
                    ]);
                }

            }
        }
        return true;
    }
    public function statusChange($data){
        $flashDeals = FlashDeal::where('id','!=',$data['id'])->get();
        foreach($flashDeals as $key => $deal){
            $deal->update([
                'status' => 0
            ]);
        }
        return FlashDeal::findOrFail($data['id'])->update([
            'status' => $data['status']
        ]);
    }
    public function featuredChange($data){
        return FlashDeal::findOrFail($data['id'])->update([
            'is_featured' => $data['is_featured']
        ]);
    }
    public function editById($id){
        return FlashDeal::findOrFail($id);
    }

    public function deleteById($id){
        $flash_deal =  FlashDeal::findOrFail($id);
        $products = $flash_deal->products->pluck('id');
        FlashDealProduct::destroy($products);
        return $flash_deal->delete();

    }
    public function getSellerProduct(){
        $user = auth()->user();
        if($user->role->type == 'superadmin' || $user->role->type == 'admin' || $user->role->type == 'staff'){
            return SellerProduct::with('product', 'seller.role')->activeSeller()->get();
        }
        elseif($user->role->type == 'seller'){
            return SellerProduct::with('product', 'seller.role')->where('user_id',$user->id)->activeSeller()->get();
        }else{
            return [];
        }
    }

    public function getActiveFlashDeal(){
        return FlashDeal::where('status', 1)->first();
    }
}
