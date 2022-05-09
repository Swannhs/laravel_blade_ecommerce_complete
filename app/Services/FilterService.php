<?php
namespace App\Services;

use App\Repositories\FilterRepository;


class FilterService
{
    protected $filterRepository;

    public function __construct(FilterRepository $filterRepository){
        $this->filterRepository = $filterRepository;
    }

    public function getAllActiveProduct($sort_by, $paginate)
    {
        return $this->filterRepository->getAllActiveProduct($sort_by, $paginate);
    }

    public function getAllActiveProductId()
    {
        return $this->filterRepository->getAllActiveProductId();
    }

    public function filterProductFromCategoryBlade(array $data, $sort_by, $paginate)
    {
        return $this->filterRepository->filterProductFromCategoryBlade($data, $sort_by, $paginate);
    }

    public function filterProductBlade(array $data, $sort_by, $paginate_by)
    {
        return $this->filterRepository->filterProductBlade($data, $sort_by, $paginate_by);
    }

    public function filterProductAPI(array $data, $sort_by, $paginate_by)
    {
        return $this->filterRepository->filterProductAPI($data, $sort_by, $paginate_by);
    }

    public function filterSortProductBlade(array $data, $session_data)
    {
        return $this->filterRepository->filterSortProductBlade($data, $session_data);
    }

    public function filterProductCategoryWise($category_id, $category_ids, $sort_by, $paginate_by)
    {
        return $this->filterRepository->filterProductCategoryWise($category_id, $category_ids, $sort_by, $paginate_by);
    }

    public function filterProductBrandWise($brand_id, $sort_by, $paginate)
    {
        return $this->filterRepository->filterProductBrandWise($brand_id, $sort_by, $paginate);
    }

    public function filterCategoryBrandWise($brand_id)
    {
        return $this->filterRepository->filterCategoryBrandWise($brand_id);
    }

    public function filterBrandCategoryWise($category_id, $category_ids)
    {
        return $this->filterRepository->filterBrandCategoryWise($category_id, $category_ids);
    }

    public function filterProductMinPrice($product_ids)
    {
        return $this->filterRepository->filterProductMinPrice($product_ids);
    }

    public function filterProductMaxPrice($product_ids)
    {
        return $this->filterRepository->filterProductMaxPrice($product_ids);
    }

    public function sortAndPaginate($products, $sort_by, $paginate_by)
    {
        return $this->filterRepository->sortAndPaginate($products, $sort_by, $paginate_by);
    }

    public function productSortByCategory($itemType,$id, $sort_by, $paginate_by){
        return $this->filterRepository->productSortByCategory($itemType,$id, $sort_by, $paginate_by);
    }

    public function getSectionProducts($section_name){
        return $this->filterRepository->getSectionProducts($section_name);
    }

    public function getConvertedMin($value){
        return $this->filterRepository->getConvertedMin($value);
    }

    public function getConvertedMax($value){
        return $this->filterRepository->getConvertedMax($value);
    }

    
}
