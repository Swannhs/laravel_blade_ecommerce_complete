<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SearchSellerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $avater = showImage('frontend/default/img/avatar.jpg');
        if($this->photo){
            $avater = showImage($this->photo);
        }
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'slug' => $this->slug,
            'seller_display_name' => $this->SellerAccount->seller_shop_display_name,
            'address' => $this->SellerBusinessInformation->business_address1,
            'avater' => $avater
        ];
    }
}
