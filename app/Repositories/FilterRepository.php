<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Modules\FrontendCMS\Entities\HomepageCustomProduct;
use Modules\FrontendCMS\Entities\HomePageSection;
use Modules\GiftCard\Entities\GiftCard;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\ProductTag;
use Modules\Product\Entities\Product;
use Modules\Product\Repositories\AttributeRepository;
use Modules\Product\Repositories\BrandRepository;
use Modules\Product\Repositories\CategoryRepository;
use Modules\Seller\Entities\SellerProduct;
use Modules\Setup\Entities\Tag;

class FilterRepository
{

    public function getAllActiveProduct($sort_by, $paginate)
    {
        $products = SellerProduct::with('skus', 'product')->where('status', 1)->whereHas('product', function ($query) {
            $query->where('status', 1);
        })->activeSeller();
        return $this->sortAndPaginate($products, $sort_by, $paginate);
    }

    public function getAllActiveProductId()
    {
        return SellerProduct::with('skus', 'product')->where('status', 1)->whereHas('product', function ($query) {
            $query->where('status', 1);
        })->latest()->activeSeller()->get()->pluck('id');
    }

    public function filterProductBlade($data, $sort_by, $paginate_by)
    {
        if (session()->has('filterDataFromCat')) {
            session()->forget('filterDataFromCat');
        }
        $requestType = $data['requestItemType'];
        $requestItem = $data['requestItem'];

        $slugs = explode(' ',$requestItem);
        $giftCards = collect();
        if($data['requestItemType'] == "search"){
            $products = $this->search_query($data['requestItem']);
            $giftCards = GiftCard::where('status', 1)->whereHas('tags', function($q) use($slugs){
                return $q->where(function($q) use ($slugs){
                    foreach($slugs as $slug){
                        $q = $q->orWhere('name', 'LIKE', "%{$slug}%");
                    }
                    return $q;
                });
                
            })->select(['*', 'name as product_name','sku as slug']);
        }
        elseif($data['requestItemType'] == "tag"){
            $tag = Tag::where('name',$requestItem)->first();
            $mainProducts = ProductTag::where('tag_id', $tag->id)->pluck('product_id')->toArray();
            $products = SellerProduct::with('product')->where('status', 1)->whereHas('product', function($query) use($mainProducts){
                return $query->whereIn('product_id',$mainProducts);
            })->activeSeller();

            $giftCards = GiftCard::where('status', 1)->whereHas('tags', function($q) use($tag){
                return $q->where('tag_id', $tag->id);
                
            })->select(['*', 'name as product_name','sku as slug'])->where('status', 1);
        }
        elseif($data['requestItemType'] == "product"){
            $result = $this->getSectionProducts($requestItem);
            $products = $result['products'];
        }
        else{
            $products = SellerProduct::query()->whereHas('product', function ($query) {
                $query->where('status', 1);
            })->with('product', 'reviews', 'skus')->activeSeller()->where('status', 1);
        }

        foreach ($data['filterType'] as $key => $filter) {
            if ($filter['filterTypeId'] == "cat" && !empty($filter['filterTypeValue'])) {
                $typeVal = $filter['filterTypeValue'];
                $products = $this->productThroughCat($typeVal, $products);
                $giftCards = collect();
            }
            if ($filter['filterTypeId'] == "brand" && !empty($filter['filterTypeValue'])) {
                $typeVal = $filter['filterTypeValue'];
                $products = $this->productThroughBrand($typeVal, $products, $requestType, $requestItem);
                $giftCards = collect();
                
            }
            if (is_numeric($filter['filterTypeId']) && !empty($filter['filterTypeValue'])) {
                $typeId = $filter['filterTypeId'];
                $typeVal = $filter['filterTypeValue'];

                $products = $this->productThroughAttribute($typeId, $typeVal, $products, $requestType, $requestItem);
                $giftCards = collect();
            }

            if ($filter['filterTypeId'] == "price_range") {
                $min_price = round(end($filter['filterTypeValue'])[0])/$this->getConvertRate();
                $max_price = round(end($filter['filterTypeValue'])[1])/$this->getConvertRate();
                $products = $this->productThroughPriceRange($min_price, $max_price, $requestType, $requestItem, $products);
                $giftCards = $giftCards->whereBetween('selling_price', [$min_price,$max_price]);
            }
            if ($filter['filterTypeId'] == "rating") {
                $rating = $filter['filterTypeValue'][0];
                $products = $this->productThroughRating($rating, $requestType, $requestItem, $products);
                $giftCards = $giftCards->where('avg_rating', '>=', $rating);
            }

            if ($data['requestItemType'] == "category" && empty($filter['filterTypeValue'])) {
                $cat = $data['requestItem'];
                $catRepo = new CategoryRepository(new Category());
                $subCat = $catRepo->getAllSubSubCategoryID($cat);
                $products = SellerProduct::with('skus', 'product')->where('status', 1)->whereHas('product', function ($query) use ($cat, $subCat) {
                    $query->whereHas('categories', function($q) use($cat){
                        $q->where('category_id',$cat)->orWhereHas('subCategories',function($q2) use($cat){
                            $q2->where('parent_id', $cat);
                        });
                    });
                })->activeSeller();
                $giftCards = collect();
            }
            if ($data['requestItemType'] == "brand" && empty($filter['filterTypeValue'])) {
                $cat = $data['requestItem'];
                $products = SellerProduct::with('skus', 'product')->where('status', 1)->whereHas('product', function ($query) use ($cat) {
                    $query->where('brand_id', $cat);
                })->activeSeller();
                $giftCards = collect();
            }
            
        }
        session()->put('filterDataFromCat', $data);

        if($giftCards->count()){
            $giftCards = $giftCards->get();
        }else{
            $giftCards = [];
        }
        $products = $products->get()->merge($giftCards);
        return $this->sortAndPaginate($products, $sort_by, $paginate_by);
    }

    public function search_query($slug){
        $slugs = explode(' ',$slug);


            $mainProducts = Product::whereHas('tags', function($q) use($slugs){
                return $q->where(function($q) use ($slugs){
                    foreach($slugs as $slug){
                        $q = $q->orWhere('name', 'LIKE', "%{$slug}%");
                    }
                    return $q;
                });
                
            })->pluck('id');

        $products = SellerProduct::with('product')->where('status', 1)->whereHas('product', function($query) use($mainProducts,$slug){
            return $query->whereIn('product_id',$mainProducts)->orWhere('product_name','LIKE', "%{$slug}%")->orWhere('description','LIKE',"%{$slug}%")->orWhere('specification','LIKE',"%{$slug}%");
        })->orWhere('product_name', 'LIKE', "%{$slug}%")->activeSeller();

        return $products;
    }


    public function filterProductAPI($data, $sort_by, $paginate_by)
    {

        $requestType = $data['requestItemType'];
        $requestItem = $data['requestItem'];
        $products = SellerProduct::query()->with('product', 'reviews')->whereHas('product', function ($query) {
            $query->where('status', 1);
        })->where('status', 1)->activeSeller();
        foreach ($data['filterType'] as $key => $filter) {
            if ($filter['filterTypeId'] == "cat" && !empty($filter['filterTypeValue'])) {
                $typeVal = $filter['filterTypeValue'];
                $products = $this->productThroughCat($typeVal, $products);
            }
            if ($filter['filterTypeId'] == "brand" && !empty($filter['filterTypeValue'])) {
                $typeVal = $filter['filterTypeValue'];
                $products = $this->productThroughBrand($typeVal, $products, $requestType, $requestItem);
            }
            if (is_numeric($filter['filterTypeId']) && !empty($filter['filterTypeValue'])) {
                $typeId = $filter['filterTypeId'];
                $typeVal = $filter['filterTypeValue'];

                $products = $this->productThroughAttribute($typeId, $typeVal, $products, $requestType, $requestItem);
            }

            if ($filter['filterTypeId'] == "price_range") {
                $min_price = round(end($filter['filterTypeValue'])[0])/$this->getConvertRate();
                $max_price = round(end($filter['filterTypeValue'])[1])/$this->getConvertRate();
                $products = $this->productThroughPriceRange($min_price, $max_price, $requestType, $requestItem, $products);
            }
            if ($filter['filterTypeId'] == "rating") {
                $rating = $filter['filterTypeValue'][0];
                $products = $this->productThroughRating($rating, $requestType, $requestItem, $products);
            }
            if ($data['requestItemType'] == "category" && empty($filter['filterTypeId'])) {
                $cat = $data['requestItem'];
                $catRepo = new CategoryRepository(new Category());
                $subCat = $catRepo->getAllSubSubCategoryID($cat);
                $products = SellerProduct::with('skus', 'product')->where('status', 1)->whereHas('product', function ($query) use ($cat, $subCat) {
                    $query->whereHas('categories', function($q) use($cat){
                        $q->where('category_id',$cat)->orWhereHas('subCategories',function($q2) use($cat){
                            $q2->where('parent_id', $cat);
                        });
                    });
                })->activeSeller();
            }
            if ($data['requestItemType'] == "brand" && empty($filter['filterTypeId'])) {
                $cat = $data['requestItem'];
                $products = SellerProduct::with('skus', 'product')->where('status', 1)->whereHas('product', function ($query) use ($cat) {
                    $query->where('brand_id', $cat);
                })->activeSeller();
            }
        }

        return $this->sortAndPaginate($products, $sort_by, $paginate_by);
    }


    public function filterSortProductBlade(array $data, $session_data)
    {
        $requestType = $data['requestItemType'];
        $requestItem = $data['requestItem'];
        $slugs = explode(' ',$requestItem);
        $giftCards = collect();
        if($data['requestItemType'] == 'search'){
            $products = $this->search_query($requestItem);
            $giftCards = GiftCard::where('status', 1)->whereHas('tags', function($q) use($slugs){
                return $q->where(function($q) use ($slugs){
                    foreach($slugs as $slug){
                        $q = $q->orWhere('name', 'LIKE', "%{$slug}%");
                    }
                    return $q;
                });
                
            })->select(['*', 'name as product_name','sku as slug']);
        }
        elseif($data['requestItemType'] == "tag"){
            $tag = Tag::where('name',$requestItem)->first();
            $mainProducts = ProductTag::where('tag_id', $tag->id)->pluck('product_id')->toArray();
            $products = SellerProduct::where('status', 1)->whereHas('product', function($query) use($mainProducts){
                return $query->whereIn('product_id',$mainProducts);
            })->activeSeller();

            $giftCards = GiftCard::where('status', 1)->whereHas('tags', function($q) use($tag){
                return $q->where('tag_id', $tag->id);
                
            })->select(['*', 'name as product_name','sku as slug'])->where('status', 1);
        }
        elseif($data['requestItemType'] == "product"){
            $result = $this->getSectionProducts($requestItem);
            $products = $result['products'];
        }
        else{
            $products = SellerProduct::query()->with('product', 'reviews', 'skus')->whereHas('product', function ($query) {
                $query->where('status', 1);
            })->where('status', 1)->activeSeller();
        }
        foreach ($session_data['filterType'] as $key => $filter) {
            if ($filter['filterTypeId'] == "cat" && !empty($filter['filterTypeValue'])) {
                $typeVal = $filter['filterTypeValue'];
                $products = $this->productThroughCat($typeVal, $products);
                $giftCards = collect();
            }
            if ($filter['filterTypeId'] == "brand" && !empty($filter['filterTypeValue'])) {
                $typeVal = $filter['filterTypeValue'];
                $products = $this->productThroughBrand($typeVal, $products, $requestType, $requestItem);
                $giftCards = collect();
            }
            if (is_numeric($filter['filterTypeId']) && !empty($filter['filterTypeValue'])) {
                $typeId = $filter['filterTypeId'];
                $typeVal = $filter['filterTypeValue'];
                $giftCards = collect();
                $products = $this->productThroughAttribute($typeId, $typeVal, $products, $requestType, $requestItem);
            }

            if ($filter['filterTypeId'] == "price_range") {
                $min_price = round(end($filter['filterTypeValue'])[0])/$this->getConvertRate();
                $max_price = round(end($filter['filterTypeValue'])[1])/$this->getConvertRate();
                $products = $this->productThroughPriceRange($min_price, $max_price, $requestType, $requestItem, $products);
                $giftCards = $giftCards->whereBetween('selling_price', [$min_price,$max_price]);
            }

            if ($filter['filterTypeId'] == "rating") {
                $rating = $filter['filterTypeValue'][0];
                $products = $this->productThroughRating($rating, $requestType, $requestItem, $products);
                $giftCards = $giftCards->where('avg_rating', '>=', $rating);
            }

            if ($data['requestItemType'] == "category" && empty($filter['filterTypeValue'])) {
                $cat = $data['requestItem'];
                $catRepo = new CategoryRepository(new Category());
                $subCat = $catRepo->getAllSubSubCategoryID($cat);
                $products = SellerProduct::with('skus', 'product')->where('status', 1)->whereHas('product', function ($query) use ($cat, $subCat) {
                    $query->whereHas('categories', function($q) use($cat){
                        $q->where('category_id',$cat)->orWhereHas('subCategories',function($q2) use($cat){
                            $q2->where('parent_id', $cat);
                        });
                    });
                })->activeSeller();
                $giftCards = collect();
            }
            if ($data['requestItemType'] == "brand" && empty($filter['filterTypeValue'])) {
                $cat = $data['requestItem'];
                $products = SellerProduct::with('skus', 'product')->where('status', 1)->whereHas('product', function ($query) use ($cat) {
                    $query->where('brand_id', $cat);
                })->activeSeller();
                $giftCards = collect();
            }
        }
        if (!empty($data['paginate'])) {
            $paginate = $data['paginate'];
        } else {
            $paginate = 6;
        }

        if($giftCards->count()){
            $giftCards = $giftCards->get();
            $products = $products->get()->merge($giftCards);
        }else{
            $giftCards = [];
        }

        return $this->sortAndPaginate($products, $data['sort_by'], $paginate);
    }


    public function filterProductCategoryWise($category_id, $category_ids, $sort_by, $paginate_by)
    {
        $products = SellerProduct::with('skus', 'product')->where('status', 1)->activeSeller()->whereHas('product', function ($query) use ($category_ids, $category_id) {
            return $query->where('status', 1)->whereHas('categories',function($q) use($category_id,$category_ids){
                return $q->where('category_id', $category_id)->orWhereHas('subCategories', function($q2)use($category_id){
                    return $q2->where('parent_id', $category_id);
                });
            });
        });

        return $this->sortAndPaginate($products, $sort_by, $paginate_by);
    }

    public function filterProductBrandWise($brand_id, $sort_by, $paginate_by)
    {
        $products = SellerProduct::with('skus', 'product')->where('status', 1)->activeSeller()->whereHas('product', function ($query) use ($brand_id) {
            return $query->where('brand_id', $brand_id)->where('status', 1);
        });

        return $this->sortAndPaginate($products, $sort_by, $paginate_by);
    }

    public function filterCategoryBrandWise($brand_id)
    {
        $categoryList = Category::whereHas('products', function ($q) use ($brand_id) {
            $q->whereHas('brand', function($q1) use($brand_id){
                $q1->where('id',$brand_id)->where('status', 1)->where('parent_id','!=',0);
            })->where('status', 1);
        })->get();
        return $categoryList;
    }

    public function filterBrandCategoryWise($category_id, $category_ids)
    {
        $seller_products =  SellerProduct::with('skus', 'product')->where('status', 1)->whereHas('product', function ($query) use ($category_id, $category_ids) {
            return $query->where('status', 1)->whereHas('categories', function($q)use($category_id){
                $q->where('category_id',$category_id)->orWhereHas('subCategories', function($q2)use($category_id){
                    $q2->where('parent_id', $category_id);
                });
            })->where('status', 1);
        })->activeSeller()->get();
        $product_ids = $seller_products->unique('product_id')->pluck('product_id');
        $brnadList = Brand::whereHas('products', function ($q) use ($product_ids) {
            $q->whereIn('id', $product_ids)->where('status', 1);
        })->get();
        return $brnadList;
    }

    public function filterProductFromCategoryBlade($data, $sort_by, $paginate)
    {
        if (session()->has('filterDataFromCat')) {
            session()->forget('filterDataFromCat');
        }
        $products = SellerProduct::query()->with('product', 'reviews')->where('status', 1)->whereHas('product', function ($query) {
            $query->where('status', 1);
        })->activeSeller();
        foreach ($data['filterType'] as $key => $filter) {
            if ($filter['filterTypeId'] == "parent_cat" && !empty($filter['filterTypeValue'])) {
                $typeVal = $filter['filterTypeValue'];
                $products = $this->productThroughParentCat($typeVal, $products);
            }

            if ($filter['filterTypeId'] == "cat" && !empty($filter['filterTypeValue'])) {
                $typeVal = $filter['filterTypeValue'];
                $products = $this->productThroughCat($typeVal, $products);
            }

            if ($filter['filterTypeId'] == "brand" && !empty($filter['filterTypeValue'])) {
                $typeVal = $filter['filterTypeValue'];
                $products = $this->productThroughBrandForAllListing($typeVal, $products);
            }
            if ($filter['filterTypeId'] != "price_range" && $filter['filterTypeId'] != "rating" && $filter['filterTypeId'] != "brand" && $filter['filterTypeId'] != "parent_cat" && $filter['filterTypeId'] != "cat" && !empty($filter['filterTypeValue'])) {
                $typeId = $filter['filterTypeId'];
                $typeVal = $filter['filterTypeValue'];
                $products = $products->where('status', 1)->whereHas('product', function ($q) use ($typeId, $typeVal) {
                    $q->whereHas('variations', function ($query) use ($typeId, $typeVal) {
                        $query->whereIn('attribute_id', [$typeId])->whereIn('attribute_value_id', $typeVal);
                    });
                });
            }
            if ($filter['filterTypeId'] == "price_range") {
                $min_price = round(end($filter['filterTypeValue'])[0])/$this->getConvertRate();
                $max_price = round(end($filter['filterTypeValue'])[1])/$this->getConvertRate();
                $products = $this->productThroughPriceRangeForAllListing($min_price, $max_price, $products);
            }

            if ($filter['filterTypeId'] == "rating") {

                $rating = $filter['filterTypeValue'][0];
                $products = $this->productThroughRatingForAllListing($rating, $products);
            }
        }
        session()->put('filterDataFromCat', $data);
        return $this->sortAndPaginate($products, $sort_by, $paginate);
    }

    public function filterProductMinPrice($product_ids)
    {
        return SellerProductSKU::whereIn('product_id', $product_ids)->get()->min('selling_price');
    }

    public function filterProductMaxPrice($product_ids)
    {
        return SellerProductSKU::whereIn('product_id', $product_ids)->get()->max('selling_price');
    }

    public function productThroughCat($typeVal, $products)
    {
        foreach($typeVal as $cat){
            $products = $products->whereHas('product', function($q1) use ($cat){
                $q1->WhereHas('categories', function($q2)use($cat){
                    $q2->where('category_id', $cat)->orWhereHas('subCategories', function($q3)use($cat){
                        $q3->where('parent_id', $cat);
                    });
                });
            });
        }
        return $products;
    }

    public function productThroughBrandForAllListing($typeVal, $products)
    {
        $products = $products->where('status', 1)->whereHas('product', function ($q) use ($typeVal) {
            $q->whereIn('brand_id', $typeVal);
        });
        return $products;
    }

    public function productThroughParentCat($typeVal, $products)
    {
        $category_ids = Category::whereHas('parentCategory', function ($q) use ($typeVal) {
            $q->whereIn('id', $typeVal);
        })->get()->pluck('id');
        foreach ($typeVal as $key => $value) {
            $category_ids->push($value);
        }
        $products = $products->where('status', 1)->whereHas('product', function ($q) use ($category_ids) {
            $q->whereHas('categories', function($q1)use( $category_ids){
                $q1->whereIn('category_id', $category_ids)->orWhereHas('subCategories', function($q2) use($category_ids){
                    $q2->whereIn('id', $category_ids);
                });
            })->where('status', 1);
        });
        return $products;
    }

    public function productThroughBrand($typeVal, $products, $requestType, $requestItem)
    {
        if ($requestType == "category") {

            $products = $products->where('status', 1)->whereHas('product', function ($q) use ($typeVal, $requestItem) {
                $q->WhereHas('categories', function ($q1) use ($requestItem) {
                    $q1->where('category_id', $requestItem)->orWhereHas('subCategories', function($q2)use($requestItem){
                        $q2->where('parent_id', $requestItem);
                    });
                })->whereIn('brand_id', $typeVal);
            });
            return $products;
        }
        else{
            $products = $products->whereHas('product', function($query)use($typeVal){
                $query->whereIn('brand_id', $typeVal);
            });
            return $products;
        }
    }

    public function productThroughAttribute($typeId, $typeVal, $products, $requestType, $requestItem)
    {
        if ($requestType ==  "category") {
            $products = $products->where('status', 1)->whereHas('product', function ($q) use ($typeId, $typeVal, $requestItem) {
                $q->whereHas('categories', function($q1)use($requestItem){
                    $q1->where('category_id',$requestItem)->orWhereHas('subCategories', function($q2) use($requestItem){
                        $q2->where('parent_id', $requestItem);
                    });
                })->whereHas('variations', function ($query) use ($typeId, $typeVal) {
                    $query->whereIn('attribute_id', [$typeId])->whereIn('attribute_value_id', $typeVal);
                })->where('status', 1);
            });

        } elseif ($requestType ==  "brand") {
            $products = $products->where('status', 1)->whereHas('product', function ($q) use ($typeId, $typeVal, $requestItem) {
                $q->whereHas('variations', function ($query) use ($typeId, $typeVal) {
                    $query->whereIn('attribute_id', [$typeId])->whereIn('attribute_value_id', $typeVal);
                })->whereIn('brand_id', [$requestItem])->where('status', 1);
            });
        } else {
            $products = $products->where('status', 1)->whereHas('product', function ($q) use ($typeId, $typeVal) {
                $q->whereHas('variations', function ($query) use ($typeId, $typeVal) {
                    $query->whereIn('attribute_id', [$typeId])->whereIn('attribute_value_id', $typeVal);
                })->where('status', 1);
            });
        }
        return $products;
    }

    public function productThroughPriceRange($min_price, $max_price, $requestType, $requestItem, $products)
    {
        if ($requestType ==  "category") {
            $products = $products->where('status', 1)->whereHas('product', function ($q) use ($requestItem) {
                $q->whereHas('categories', function($q1) use($requestItem){
                    $q1->where('category_id',$requestItem)->orWhereHas('subCategories', function($q2) use($requestItem){
                        $q2->where('parent_id', $requestItem);
                    });
                })->where('status', 1);
            });
        }
        if ($requestType ==  "brand") {
            $products = $products->where('status', 1)->whereHas('product', function ($q) use ($requestItem) {
                $q->whereIn('brand_id', [$requestItem])->where('status', 1);
            });
        }
        $products = $products->where('status', 1)->whereHas('skus', function ($q) use ($min_price, $max_price) {
            $q->whereBetween('selling_price', array($min_price, $max_price));
        });
        return $products;
    }

    private function productThroughRating($rating, $requestType, $requestItem, $products)
    {
        if ($requestType ==  "category") {

            $products = $products->where('status', 1)->whereHas('product', function ($q) use ($requestItem) {
                $q->whereHas('categories', function($q1) use($requestItem){
                    $q1->where('category_id',$requestItem)->orWhereHas('subCategories', function($q2) use($requestItem){
                        $q2->where('parent_id', $requestItem);
                    });
                });
            });
        }
        if ($requestType ==  "brand") {
            $products = $products->where('status', 1)->whereHas('product', function ($q) use ($requestItem) {
                $q->whereIn('brand_id', [$requestItem]);
            });
        }

        $products = $products->where('status', 1)->where('avg_rating', '>=', $rating);
        return $products;
    }

    public function productThroughPriceRangeForAllListing($min_price, $max_price, $products)
    {
        $products = $products->where('status', 1)->whereHas('skus', function ($q) use ($min_price, $max_price) {
            $q->whereBetween('selling_price', array($min_price, $max_price));
        });
        return $products;
    }

    private function productThroughRatingForAllListing($rating, $products)
    {
        $products = $products->where('status', 1)->where('avg_rating', '>=', $rating);

        return $products;
    }

    public function sortAndPaginate($products, $sort_by, $paginate_by)
    {
        
        $sort = 'desc';
            $column = 'created_at';
            if(in_array($sort_by,['old','alpha_asc','low_to_high'])){
                $sort = 'asc';
            }
            if(in_array($sort_by,['alpha_asc','alpha_desc'])){
                $column = 'product_name';
            }
            elseif ($sort_by == "low_to_high") {
                $column = 'min_sell_price';
            }
            elseif ($sort_by == "high_to_low") {
                $column = 'max_sell_price';
            }
        if(get_class($products) == \Illuminate\Database\Eloquent\Builder::class){
            $products = $products->orderBy($column, $sort);
            
        }else{
            if($sort == 'asc'){
                $products = $products->sortBy($column);
            }else{
                $products = $products->sortByDesc($column);
            }
    
        }

        return $products->paginate(($paginate_by != null) ? $paginate_by : 9);
        
    }

    public function productSortByCategory($itemType, $id, $sort_by, $paginate_by)
    {
        $category_id = 0;

        $item = $itemType;
        $data = [];

        if ($item == 'category') {
            $category_id = $id;
            $catRepo = new CategoryRepository(new Category());
            $data['CategoryList'] = $catRepo->subcategory($category_id);
            $data['filter_name'] = $catRepo->show($category_id);
            $category_ids = $catRepo->getAllSubSubCategoryID($category_id);
            $data['brandList'] = $this->filterBrandCategoryWise($category_id, $category_ids);
            $data['products'] = $this->filterProductCategoryWise($category_id, $category_ids, $sort_by, $paginate_by);
            $attributeRepo = new AttributeRepository;
            $data['attributeLists'] = $attributeRepo->getAttributeForSpecificCategory($category_id, $category_ids);
            $data['category_id'] = $category_id;
            $data['color'] = $attributeRepo->getColorAttributeForSpecificCategory($category_id, $category_ids);
        }

        if ($item == 'brand') {
            $brand_id = $id;
            $brandRepo = new BrandRepository(new Brand());
            $data['filter_name'] = $brandRepo->find($brand_id);
            $data['brand_id'] = $brand_id;
            $data['products'] = $this->filterProductBrandWise($brand_id, $sort_by, $paginate_by);
            $data['CategoryList'] = $this->filterCategoryBrandWise($brand_id);
            $attributeRepo = new AttributeRepository;
            $data['attributeLists'] = $attributeRepo->getAttributeForSpecificBrand($brand_id);
            $data['color'] = $attributeRepo->getColorAttributeForSpecificBrand($brand_id);
        }

        if ($item == 'tag') {

            $tag = Tag::where('name',$id)->first();
            $mainProducts = ProductTag::where('tag_id', $tag->id)->pluck('product_id')->toArray();
            $products = SellerProduct::with('product')->where('status', 1)->whereHas('product', function($query) use($mainProducts){
                return $query->whereIn('product_id',$mainProducts);
            })->activeSeller();

            $giftCards = GiftCard::where('status', 1)->whereHas('tags', function($q) use($tag){
                return $q->where('tag_id', $tag->id);
                
            })->select(['*', 'name as product_name','sku as slug'])->where('status', 1);

            if($giftCards->count()){
                $giftCards = $giftCards->get();
            }else{
                $giftCards = [];
            }
            $products = $products->get()->merge($giftCards);
            

            $data['products'] = $this->sortAndPaginate($products, $sort_by, $paginate_by);
        }
        if($item == 'search'){

            $slugs = explode(' ',$id);
            $giftCards = collect();

            $giftCards = GiftCard::where('status', 1)->whereHas('tags', function($q) use($slugs){
                return $q->where(function($q) use ($slugs){
                    foreach($slugs as $slug){
                        $q = $q->orWhere('name', 'LIKE', "%{$slug}%");
                    }
                    return $q;
                });
                
            })->select(['*', 'name as product_name','sku as slug']);

            $products = $this->search_query($id);
        
            if($giftCards->count()){
                $giftCards = $giftCards->get();
            }else{
                $giftCards = [];
            }
            $products = $products->get()->merge($giftCards);

            $data['products'] = $this->sortAndPaginate($products, $sort_by, $paginate_by);
        }
        if ($item == 'product') {
            $result = $this->getSectionProducts($id);
            $products = $result['products'];

            $data['products'] = $this->sortAndPaginate($products, $sort_by, $paginate_by);
        }

        return $data['products'];
    }

    public function getSectionProducts($section_name){
        $section = HomePageSection::where('section_name',$section_name)->first();

        $products = SellerProduct::with('reviews')->where('status', 1)->activeSeller();

        $data['products'] = $products;
        $data['section'] = $section;
        if(request()->sort_by){
            return $data;
        }
        if($section->type == 1){

            $products = $products->whereHas('product', function($query){
                return $query->where('status', 1)->whereHas('categories', function($q){
                    return $q->orderBy('id');
                });
            });
        }else{
            $products = $products->whereHas('product', function($query){
                $query->where('status', 1);
            });
        }
        if($section->type == 2){
            $products = $products->latest();
        }
        if($section->type == 3){
            $products->orderByDesc('recent_view');
        }
        if($section->type == 4){
            $products->orderByDesc('total_sale');

        }
        if($section->type == 5){

            $products = $products->withCount('reviews')->orderByDesc('reviews_count');
        }
        if($section->type == 6){
            $product_ids = HomepageCustomProduct::where('section_id',$section->id)->get();
            $products =  $products->whereIn('id',$product_ids->pluck('seller_product_id'));

        }
        $data['products'] = $products;
        return $data;
    }

    public function getConvertedMin($value){
        if(auth()->check() && auth()->user()->currency->code != app('general_setting')->currency_code){
            $rate = auth()->user()->currency->convert_rate;
            $value = $value * $rate;
        }else{
            if(Session::has('currency')){
                $currency = DB::table('currencies')->where('id', Session::get('currency'))->first();
                $rate = $currency->convert_rate;
                $value = $value * $rate;
            }
        }
        return $value;
    }
    public function getConvertedMax($value){
        if(auth()->check() && auth()->user()->currency->code != app('general_setting')->currency_code){
            $rate = auth()->user()->currency->convert_rate;
            $value = $value * $rate;
        }else{
            if(Session::has('currency')){
                $currency = DB::table('currencies')->where('id', Session::get('currency'))->first();
                $rate = $currency->convert_rate;
                $value = $value * $rate;
            }
        }
        return $value;
    }

    public function getConvertRate(){
        $rate = 1;
        if(auth()->check() && auth()->user()->currency->code != app('general_setting')->currency_code){
            $rate = auth()->user()->currency->convert_rate;
        }else{
            if(Session::has('currency')){
                $currency = DB::table('currencies')->where('id', Session::get('currency'))->first();
                $rate = $currency->convert_rate;
            }
        }
        return $rate;
    }
}
