<?php
namespace App\Repositories;

use App\Models\User;
use Modules\MultiVendor\Entities\SellerAccount;
use Modules\Seller\Entities\SellerProduct;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\ProductTag;
use Modules\Product\Entities\Product;

class SellerRepository{

    protected $seller;

    public function __construct(User $seller)
    {
        $this->seller = $seller;
    }

    public function GetSellerList(){
        return $this->seller::with('sellerReviews.customer','SellerAccount','SellerBusinessInformation.country','SellerBusinessInformation.state','SellerBusinessInformation.city')->where('is_active', 1)->where('role_id', 5)->select('id','first_name','last_name','avatar','phone','date_of_birth')->latest()->paginate(10);
    }

    public function getBySellerID($id)
    {
        return $this->seller::with('seller_products.product')->where('id',$id)->firstOrfail();
    }

    public function getBySellerSlug($slug)
    {
        return $this->seller::with('seller_products.product')->where('slug',$slug)->first();
    }

    public function getSellerByIDAPI($id){
        if(isModuleActive('MultiVendor')){
            $user = User::find($id);
            if($user){
                if($user->role->type == 'customer'){
                    return 'seller not found';
                }else{
                    return $this->seller::with(array('sellerReviews','SellerAccount','SellerBusinessInformation.country','SellerBusinessInformation.state','SellerBusinessInformation.city'))->where('is_active', 1)->where('id',$id)->first(['id','first_name','last_name','avatar','phone','date_of_birth']);
                }
            }
        }
        return 'seller not found';

    }

    public function getProduct($seller_id,$sort_by,$paginate)
    {
        $products = SellerProduct::with('skus','product','reviews.customer', 'reviews.images')->where('user_id',$seller_id)->where('status',1)->whereHas('product', function($query){
            $query->where('status', 1);
        })->activeSeller();
        return $this->sortAndPaginate($products, $sort_by, $paginate);
    }

    public function getSellerAllProduct($seller_id)
    {
        return SellerProduct::with('skus','product')->where('user_id',$seller_id)->where('status',1)->whereHas('product', function($query){
            $query->where('status', 1);
        })->activeSeller()->get();
    }

    public function getCategoryList($seller_id)
    {
        $product_ids = $this->getSellerAllProduct($seller_id)->pluck('product_id');
        $category_ids = Product::whereIn('id', $product_ids)->get()->unique('category_id')->pluck('category_id');
        $category_list = Category::with('parentCategory')->whereIn('id', $category_ids)->get();
        return $category_list;
    }

    public function getBrandList($seller_id)
    {
        $product_ids = $this->getSellerAllProduct($seller_id)->pluck('product_id');
        $brand_ids = Product::whereIn('id', $product_ids)->get()->unique('brand_id')->pluck('brand_id');
        $brand_list = Brand::whereIn('id', $brand_ids)->get();
        return $brand_list;
    }

    public function getProductLowestPrice($seller_id)
    {

        $product_ids = $this->getSellerAllProduct($seller_id)->pluck('id');
        $orginal_price = SellerProductSKU::whereIn('product_id', $product_ids)->get()->min('selling_price');
        $filterRepo = new FilterRepository();
        $min_price = $filterRepo->getConvertedMin($orginal_price);
        return $min_price;
    }

    public function getProductHighestPrice($seller_id)
    {
        $product_ids = $this->getSellerAllProduct($seller_id)->pluck('id');
        $orginal_price = SellerProductSKU::whereIn('product_id', $product_ids)->get()->max('selling_price');
        $filterRepo = new FilterRepository();
        $max_price = $filterRepo->getConvertedMax($orginal_price);
        return $max_price;
    }

    public function filterProductBlade($data, $sort_by, $paginate_by, $seller_id)
    {
        if (session()->has('filterDataFromCat')) {
            session()->forget('filterDataFromCat');
        }

        $products = SellerProduct::query()->where('user_id', $seller_id)->whereHas('product', function($query){
            $query->where('status', 1);
        })->with('skus','product')->activeSeller();
        foreach ($data['filterType'] as $key => $filter) {
            if ($filter['filterTypeId'] == "cat" && !empty($filter['filterTypeValue'])) {
                $typeVal = $filter['filterTypeValue'];
                $products = $this->productThroughCat($typeVal, $products, $seller_id);
            }
            if ($filter['filterTypeId'] == "brand" && !empty($filter['filterTypeValue'])) {
                $typeVal = $filter['filterTypeValue'];
                $products = $this->productThroughBrand($typeVal, $products, $seller_id);

            }
            if(is_numeric ( $filter['filterTypeId'] ) && !empty($filter['filterTypeValue'])) {
                $typeId = $filter['filterTypeId'];
                $typeVal = $filter['filterTypeValue'];

                $products = $this->productThroughAttribute($typeId, $typeVal, $products, $seller_id);
            }

            if ($filter['filterTypeId'] == "price_range") {
                $filterRepo = new FilterRepository();
                $min_price = round(end($filter['filterTypeValue'])[0])/$filterRepo->getConvertRate();
                $max_price = round(end($filter['filterTypeValue'])[1])/$filterRepo->getConvertRate();
                $products = $this->productThroughPriceRange($min_price, $max_price, $products, $seller_id);

            }

            if ($filter['filterTypeId'] == "rating") {
                $rating = $filter['filterTypeValue'][0];
                $products = $this->productThroughRating($rating, $products, $seller_id);

            }

        }
        session()->put('filterDataFromCat', $data);
        return $this->sortAndPaginate($products, $sort_by, $paginate_by);
    }

    public function filterSortProductBlade(array $data, $session_data, $seller_id)
    {
        if (!empty($data['paginate'])) {
            $paginate = $data['paginate'];
        }else {
            $paginate = 6;
        }
        $products = SellerProduct::query()->where('user_id', $seller_id)->whereHas('product', function($query){
            $query->where('status', 1);
        })->activeSeller()->with('skus','product');
        foreach ($session_data['filterType'] as $key => $filter) {
            if ($filter['filterTypeId'] == "cat" && !empty($filter['filterTypeValue'])) {
                $typeVal = $filter['filterTypeValue'];
                $products = $this->productThroughCat($typeVal, $products, $seller_id);
            }
            if ($filter['filterTypeId'] == "brand" && !empty($filter['filterTypeValue'])) {
                $typeVal = $filter['filterTypeValue'];
                $products = $this->productThroughBrand($typeVal, $products, $seller_id);

            }
            if(is_numeric ( $filter['filterTypeId'] ) && !empty($filter['filterTypeValue'])) {
                $typeId = $filter['filterTypeId'];
                $typeVal = $filter['filterTypeValue'];

                $products = $this->productThroughAttribute($typeId, $typeVal, $products, $seller_id);
            }

            if ($filter['filterTypeId'] == "price_range") {
                $filterRepo = new FilterRepository();
                $min_price = round(end($filter['filterTypeValue'])[0])/$filterRepo->getConvertRate();
                $max_price = round(end($filter['filterTypeValue'])[1])/$filterRepo->getConvertRate();
                $products = $this->productThroughPriceRange($min_price, $max_price, $products, $seller_id);

            }
            if ($filter['filterTypeId'] == "rating") {
                $rating = $filter['filterTypeValue'][0];
                $products = $this->productThroughRating($rating, $products, $seller_id);

            }
        }

        return $this->sortAndPaginate($products, $data['sort_by'], $paginate);
    }

    public function productThroughCat($typeVal, $products, $seller_id)
    {
        $products = $products->where('user_id',$seller_id)->where('status', 1)->whereHas('product', function($q) use ($typeVal){
            $q->whereIn('category_id', $typeVal);
        });
        return $products;
    }

    public function productThroughBrand($typeVal, $products, $seller_id)
    {
        $products = $products->where('user_id',$seller_id)->where('status', 1)->whereHas('product', function($q) use ($typeVal){
            $q->whereIn('brand_id', $typeVal);
        });
        return $products;
    }

    public function productThroughAttribute($typeId, $typeVal, $products, $seller_id)
    {
        $products = $products->where('user_id',$seller_id)->where('status', 1)->whereHas('product', function($q) use ($typeId, $typeVal){
            $q->whereHas('variations', function($query) use ($typeId, $typeVal){
                $query->whereIn('attribute_id', [$typeId])->whereIn('attribute_value_id', $typeVal);
            });
        });
        return $products;
    }

    public function productThroughPriceRange($min_price, $max_price, $products, $seller_id)
    {
        $products = $products->where('user_id', $seller_id)->where('status', 1)->whereHas('skus', function($q) use($min_price, $max_price){
            $q->whereBetween('selling_price',array($min_price, $max_price));
        });
        return $products;
    }

    private function productThroughRating($rating, $products, $seller_id){
        $products = $products->where('user_id', $seller_id)->where('status', 1)->where('avg_rating', '>=', $rating);
        return $products;
    }

    public function sortAndPaginate($products, $sort_by, $paginate_by)
    {

        if ($sort_by != null) {
            if ($sort_by == "new") {
                $products = $products->latest()->paginate(($paginate_by != null) ? $paginate_by : 9);
            }
            if ($sort_by == "old") {
                $products = $products->paginate(($paginate_by != null) ? $paginate_by : 9);
            }
            if ($sort_by == "alpha_asc") {
                $products = $products->orderBy('product_name')->paginate(($paginate_by != null) ? $paginate_by : 9);
            }
            if ($sort_by == "alpha_desc") {
                $products = $products->orderByDesc('product_name')->paginate(($paginate_by != null) ? $paginate_by : 9);
            }
            if ($sort_by == "low_to_high") {
                $products = $products->orderBy("min_sell_price", "asc")->paginate(($paginate_by != null) ? $paginate_by : 9);
            }
            if ($sort_by == "high_to_low") {
                $products = $products->orderBy("max_sell_price", "desc")->paginate(($paginate_by != null) ? $paginate_by : 9);
            }
        }else {
            $products = $products->latest()->paginate(($paginate_by != null) ? $paginate_by : 9);
        }
        return $products;
    }

}
