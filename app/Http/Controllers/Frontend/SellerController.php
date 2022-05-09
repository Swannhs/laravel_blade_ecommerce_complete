<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Services\SellerService;
use App\Repositories\FilterRepository;
use Modules\Product\Repositories\CategoryRepository;
use \Modules\Product\Repositories\AttributeRepository;
use Modules\Product\Entities\Category;

class SellerController extends Controller
{
    protected $sellerService;
    public function __construct(SellerService $sellerService)
    {
        $this->sellerService = $sellerService;
        $this->middleware('maintenance_mode');
    }

    public function index($seller_slug)
    {
        
        if (session()->has('filterDataFromCat')) {
            session()->forget('filterDataFromCat');
        }

        $data['seller'] = $this->sellerService->getBySellerSlug($seller_slug);
        if ($data['seller']) {
            $id = $data['seller']->id;
        } else {
            $id = base64_decode($seller_slug);
            $data['seller'] = $this->sellerService->getBySellerID($id);
        }

        $data['products'] = $this->sellerService->getProduct($id, null, null);
        $data['CategoryList'] = $this->sellerService->getCategoryList($id);
        $data['brandList'] = $this->sellerService->getBrandList($id);
        $data['min_price_lowest'] = $this->sellerService->getProductLowestPrice($id);
        $data['max_price_highest'] = $this->sellerService->getProductHighestPrice($id);
        $reviews = $data['seller']->sellerReviews->where('status', 1)->pluck('rating');
        if (count($reviews) > 0) {
            $value = 0;
            $rating = 0;
            foreach ($reviews as $review) {
                $value += $review;
            }
            $data['seller_rating'] = $value / count($reviews);
            $data['seller_total_review'] = count($reviews);
        } else {
            $data['seller_rating'] = 0;
            $data['seller_total_review'] = 0;
        }
        return view(theme('pages.merchant_page'), $data);
    }

    public function fetchPagenateData(Request $request, $seller_id)
    {
        $id = base64_decode($seller_id);
        if ($request->has('paginate')) {
            $paginate = $request->paginate;
            $data['paginate'] = $request->paginate;
        } else {
            $paginate = 6;
        }
        if ($request->has('sort_by')) {
            $data['sort_by'] = $request->sort_by;
            $sort_by = $request->sort_by;
        } else {
            $sort_by = null;
        }
        $data['seller'] = $this->sellerService->getBySellerID($id);
        $data['products'] = $this->sellerService->getProduct($id, $sort_by, $paginate);

        return view(theme('partials.merchant_page_paginate_data'), $data);
    }

    public function get_colors_by_type(Request $request)
    {
        if ($request->type == "cat") {
            $catRepo = new CategoryRepository(new Category());
            $category_ids = $catRepo->subcategory($request->id)->pluck('id');
            $attributeRepo = new AttributeRepository;
            $data['color'] = $attributeRepo->getColorAttributeForSpecificCategory($request->id, $category_ids);
        }
        if ($request->type == "brand") {
            $attributeRepo = new AttributeRepository;
            $data['color'] = $attributeRepo->getColorAttributeForSpecificBrand($request->id);
        }
        return view(theme('partials.color_attribute'), $data);
    }

    public function get_attribute_by_type(Request $request)
    {
        if ($request->type == "cat") {
            $catRepo = new CategoryRepository(new Category());
            $category_ids = $catRepo->subcategory($request->id)->pluck('id');
            $attributeRepo = new AttributeRepository;
            $data['attributeLists'] = $attributeRepo->getAttributeForSpecificCategory($request->id, $category_ids);
        }
        if ($request->type == "brand") {
            $attributeRepo = new AttributeRepository;
            $data['attributeLists'] = $attributeRepo->getAttributeForSpecificBrand($request->id);
        }
        return view(theme('partials.attributes'), $data);
    }

    public function filterIndexByType(Request $request)
    {
        $sort_by = null;
        $paginate = null;
        if ($request->has('sort_by')) {
            $data['sort_by'] = $request->sort_by;
        }
        if ($request->has('paginate')) {
            $data['paginate'] = $request->paginate;
        }
        $data['products'] = $this->sellerService->filterProductBlade($request->except("_token"), $sort_by, $paginate, $request->seller_id);

        return view(theme('partials.merchant_page_paginate_data'), $data);
    }
    public function fetchFilterPagenateDataByType(Request $request)
    {
        $sort_by = null;
        $paginate = null;
        if ($request->has('sort_by')) {
            $sort_by = $request->sort_by;
            $data['sort_by'] = $request->sort_by;
        }
        if ($request->has('paginate')) {
            $paginate = $request->paginate;
            $data['paginate'] = $request->paginate;
        }
        $data['products'] = $this->sellerService->filterProductBlade(session()->get('filterDataFromCat'), $sort_by, $paginate, $request->seller_id);

        return view(theme('partials.merchant_page_paginate_data'), $data);
    }

    public function sortFilterIndexByType(Request $request)
    {
        $sort_by = null;
        $paginate = null;
        if ($request->has('sort_by')) {
            $sort_by = $request->sort_by;
            $data['sort_by'] = $request->sort_by;
        }
        if ($request->has('paginate')) {
            $paginate = $request->paginate;
            $data['paginate'] = $request->paginate;
        }
        if (session()->has('filterDataFromCat')) {
            $data['products'] = $this->sellerService->filterSortProductBlade($request->except("_token"), session()->get('filterDataFromCat'), $request->seller_id);
        } else {
            $data['products'] = $this->sellerService->getProduct($request->seller_id, $sort_by, $paginate);
        }

        return view(theme('partials.merchant_page_paginate_data'), $data);
    }
}
