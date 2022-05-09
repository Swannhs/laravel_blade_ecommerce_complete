<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            "id"=> $this->id,
            "name"=> $this->name,
            "logo"=> $this->logo,
            "description"=> $this->description,
            "link"=> $this->link,
            "status"=> $this->status,
            "featured"=> $this->featured,
            "meta_title"=> $this->meta_title,
            "meta_description"=> $this->meta_description,
            "sort_id"=> $this->sort_id,
            "total_sale"=> $this->total_sale,
            "avg_rating"=> $this->avg_rating,
            "slug"=> $this->slug,
            "AllProducts" => $this->AllProducts
        ];
    }
}
