<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"=> $this->id,
            "first_name"=> $this->first_name,
            "last_name"=> $this->last_name,
            "avatar"=> $this->avatar,
            "phone"=> $this->phone,
            "date_of_birth"=> $this->date_of_birth,
            "seller_reviews"=> $this->seller_reviews,
            "seller_account" => $this->seller_account,
            "seller_business_information" => $this->seller_business_information,
            "SellerProductsAPI" => $this->SellerProductsAPI
        ];
    }
}
