<?php

namespace Modules\Product\Services;

use Illuminate\Support\Facades\Validator;
use Modules\Product\Repositories\AttributeRepository;

class AttributeService
{
    protected $attributeRepository;

    public function __construct(AttributeRepository  $attributeRepository)
    {
        $this->attributeRepository= $attributeRepository;
    }

    public function getActiveAll()
    {
        return $this->attributeRepository->getActiveAll();
    }

    public function getActiveAllWithoutColor()
    {
        return $this->attributeRepository->getActiveAllWithoutColor();
    }

    public function getColorAttr()
    {
        return $this->attributeRepository->getColorAttr();
    }

    public function save($data)
    {
        return $this->attributeRepository->create($data);
    }

    public function update($data,$id)
    {
        return $this->attributeRepository->update($data,$id);
    }

    public function getAll()
    {
        return $this->attributeRepository->getAll();
    }

    public function deleteById($id)
    {
        return $this->attributeRepository->delete($id);
    }

    public function findById($id)
    {
        return $this->attributeRepository->find($id);
    }

    public function getAttributeForSpecificCategory($category_id, $category_ids)
    {
        return $this->attributeRepository->getAttributeForSpecificCategory($category_id, $category_ids);
    }

    public function getColorAttributeForSpecificCategory($category_id, $category_ids)
    {
        return $this->attributeRepository->getColorAttributeForSpecificCategory($category_id, $category_ids);
    }

    public function getColorAttributeForSpecificBrand($brand_id)
    {
        return $this->attributeRepository->getColorAttributeForSpecificBrand($brand_id);
    }

    public function getAttributeForSpecificBrand($brand_id)
    {
        return $this->attributeRepository->getAttributeForSpecificBrand($brand_id);
    }

}
