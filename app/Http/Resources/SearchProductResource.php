<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SearchProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $thumb_img = '';
        $url = '';
        $discount_price = 0;
        $selling_price = 0;
        $stock = 0;
        $hasDiscount = 0;
        if($this->ProductType == 'product'){
            if($this->thum_img != null){
                $thumb_img = showImage($this->thum_img);
            }else{
                $thumb_img = showImage($this->product->thumbnail_image_source);
            }
            if($this->hasDeal){
                $hasDiscount = 1;
                $discount_price = selling_price($this->skus[0]->selling_price, $this->hasDeal->discount_type, $this->hasDeal->discount);
            }
            elseif($this->hasDiscount == 'yes'){
                $hasDiscount = 1;
                $discount_price = selling_price($this->skus[0]->selling_price, $this->discount_type, $this->discount);
            }else{
                $discount_price = $this->skus[0]->selling_price;
            }
            if($this->stock_manage == 1){
                $stock_amount = 0;
                foreach($this->skus as $sku){
                    $stock_amount += $sku->product_stock;
                }
                if($stock_amount > 1){
                    $stock = 1;
                }
            }else{
                $stock = 1;
            }
            $selling_price = $this->skus[0]->selling_price;
            $url = route('frontend.item.show',$this->slug);
            return [
                'product_name' => $this->product_name,
                'thumb_img' => $thumb_img,
                'selling_price' => $selling_price,
                'hasDiscount' => $hasDiscount,
                'discount_price' => $discount_price,
                'stock' => $stock,
                'url' => $url
            ];
        }else{
            if($this->hasDiscount()){
                $hasDiscount = 1;
                $discount_price = selling_price($this->selling_price, $this->discount_type, $this->discount);
            }else{
                $discount_price = $this->selling_price;
            }
            $url = route('frontend.gift-card.show',$this->sku);
            return [
                'product_name' => $this->name,
                'thumb_img' => showImage($this->thumbnail_image),
                'selling_price' => $this->selling_price,
                'hasDiscount' => $hasDiscount,
                'discount_price' => $discount_price,
                'stock' => 1,
                'url' => $url
            ];
        }
        
    }
}
