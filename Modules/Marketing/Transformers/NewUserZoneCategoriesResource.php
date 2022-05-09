<?php

namespace Modules\Marketing\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Product\Transformers\CategoryResource;

class NewUserZoneCategoriesResource extends JsonResource
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
            "position"=> $this->position,
            "category" => new CategoryResource($this->category)
        ];
    }
}
