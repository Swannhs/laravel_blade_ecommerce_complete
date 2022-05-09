<?php

namespace Modules\Marketing\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class NewUserZoneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title"=> $this->title,
            "background_color" => $this->background_color,
            "slug" => $this->slug,
            "banner_image" => $this->banner_image,
            "product_navigation_label"=> $this->product_navigation_label,
            "category_navigation_label" => $this->category_navigation_label,
            "coupon_navigation_label" => $this->coupon_navigation_label,
            "product_slogan" => $this->product_slogan,
            "category_slogan" => $this->category_slogan,
            "coupon_slogan" => $this->coupon_slogan,
            "status" => $this->status,
            "AllProducts" => $this->AllProducts,
            "categories" => NewUserZoneCategoriesResource::collection($this->categories),
            "coupon" => new NewUserZoneCouponResource($this->coupon),
            "coupon_categories" => NewUserZoneCouponCategoriesResource::collection($this->couponCategories)
        ];
    }
}
