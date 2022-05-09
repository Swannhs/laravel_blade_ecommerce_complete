<?php
namespace App\Repositories;

use App\Models\Compare;
use Illuminate\Support\Facades\Session;
use Modules\Seller\Entities\SellerProductSKU;

class CompareRepository{
    


    public function getProduct($user_id){
        $products = [];

        if($user_id != null){
            $collects = Compare::where('customer_id', $user_id)->orderBy('product_type', 'desc')->get();
            foreach($collects as $collect){
                $product = SellerProductSKU::with('product')->where('id',$collect->product_sku_id)->whereHas('product', function($query){
                    return $query->activeSeller();
                })->first();
                if($product){
                    $products[] = $product;
                }
            }
        }else{

            if(Session::has('compare')){
                $dataList = Session::get('compare');
                $collcets =  collect($dataList);
                
                $collcets =  $collcets->sortByDesc('product_type');
                $products = [];
                foreach($collcets as $collcet){
                    $product = SellerProductSKU::with('product')->where('id',$collcet['product_sku_id'])->whereHas('product', function($query){
                        return $query->activeSeller();
                    })->first();
                    if($product){
                        $products[] = $product;
                    }
                    
                }
            }
        }
        return $products;
    }

    public function store($data, $user_id){

        if($user_id != null){
            $product_check = Compare::where('customer_id', $user_id)->where('product_sku_id', $data['product_sku_id'])->first();
            if($product_check){
                return true;
            }else{
                Compare::create([
                    'customer_id' => $user_id,
                    'data_type' => ($data['data_type'] == 'gift_card')?'gift_card':'product',
                    'product_type' => ($data['product_type'] == 1)?0:1,
                    'product_sku_id' => $data['product_sku_id']
                ]);
                return true;
            }
        }else{
            $compareData = [];
            $compareData['product_sku_id'] = $data['product_sku_id'];
            $compareData['data_type'] =  ($data['data_type'] == 'gift_card')?'gift_card':'product';
            $compareData['product_type'] =  ($data['product_type'] == 1)?0:1;

            if(Session::has('compare')){
                $foundInCompare = false;
                $compare = collect();

                foreach (Session::get('compare') as $key => $compareItem){
                    if($compareItem['product_sku_id'] == $data['product_sku_id']){

                        $foundInCompare = true;
                    }
                    $compare->push($compareItem);
                }

                if (!$foundInCompare) {
                    $compare->push($compareData);
                }
                Session::put('compare', $compare);
                return true;
            }else{
                $compare = collect([$compareData]);
                Session::put('compare', $compare);
                return true;
            }
        }

        return false;

    }

    public function removeItem($id, $user_id){

        if($user_id != null){
            $item = Compare::where('customer_id', $user_id)->where('product_sku_id', $id)->first();
            if($item){
                $item->delete();
                return true;
            }else{
                return false;
            }
        }else{
            if(Session::has('compare')){
                $compares = Session::get('compare', collect([]));
    
                foreach($compares as $key => $compare){
    
                    if($compare['product_sku_id'] == $id){
                        $compares->forget($key);
                    }
                }
                Session::put('compare', $compares);
            }
            return true;
        }
        return false;
    }

    public function reset($user_id){
        if($user_id != null){
            $items = Compare::where('customer_id', $user_id)->pluck('id');
            Compare::destroy($items);
            return true;
        }else{
            Session::forget('compare');
            return true;
        }
        return false;
    }

    public function totalCompareItem($user_id){
        if($user_id != null){
            $items = Compare::where('customer_id', $user_id)->pluck('id');
        }else{
            $items = Session::get('compare', collect([]));
        }
        return count($items);
    }

}
