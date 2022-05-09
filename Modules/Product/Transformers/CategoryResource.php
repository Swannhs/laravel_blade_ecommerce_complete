<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
           "name" => $this->name,
           "slug"=> $this->slug,
           "parent_id"=> $this->parent_id,
           "depth_level"=> $this->depth_level,
           "icon"=> $this->icon,
           "searchable"=> $this->searchable,
           "status" => $this->status,
           "total_sale"=> $this->total_sale,
           "avg_rating"=> $this->avg_rating,
           "commission_rate"=> $this->commission_rate,
           "AllProducts" => $this->AllProducts,
           "category_image" => $this->categoryImage,
           "parent_category" => $this->parentCategory,
           "sub_categories" => $this->subCategories
        ];
    }
}
