<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SearchTerm;
use Illuminate\Http\Request;
use Modules\FrontendCMS\Entities\HomepageCustomProduct;
use Modules\FrontendCMS\Entities\HomePageSection;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\ProductTag;
use Modules\Seller\Entities\SellerProduct;
use Modules\Product\Repositories\CategoryRepository;
use Modules\Product\Repositories\BrandRepository;
use \Modules\Product\Repositories\AttributeRepository;
use App\Services\FilterService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Modules\GeneralSetting\Entities\Currency;
use Modules\GiftCard\Entities\GiftCard;
use Modules\Product\Entities\Attribute;
use Modules\Product\Entities\CategoryProduct;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductVariations;
use Modules\Setup\Entities\Tag;
use Str;

class CategoryController extends Controller
{
    protected $filterService;
    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
        $this->middleware('maintenance_mode');
    }
    public function index()
    {
        $data['products'] = $this->filterService->getAllActiveProduct(null, null);
        $catRepo = new CategoryRepository(new Category());
        $data['CategoryList'] = $catRepo->category();
        $attributeRepo = new AttributeRepository;
        $data['attributeLists'] = $attributeRepo->getActiveAllWithoutColor();
        $data['color'] = $attributeRepo->getColorAttr();
        if (session()->has('filterDataFromCat')) {
            session()->forget('filterDataFromCat');
        }
        $product_ids = $this->filterService->getAllActiveProductId();

        $product_min_price = $this->filterService->filterProductMinPrice($product_ids);
        $product_max_price = $this->filterService->filterProductMaxPrice($product_ids);
        $product_min_price = $this->filterService->getConvertedMin($product_min_price);
        $product_max_price = $this->filterService->getConvertedMax($product_max_price);
        $data['min_price_lowest'] = $product_min_price;
        $data['max_price_highest'] = $product_max_price;


        return view(theme('pages.category'), $data);
    }

    public function fetchPagenateData(Request $request)
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
        $data['products'] = $this->filterService->getAllActiveProduct($sort_by, $paginate);
        return view(theme('partials.category_paginate_data'), $data);
    }

    public function filterIndex(Request $request)
    {
        $data['products'] = $this->filterService->filterProductFromCategoryBlade($request->except("_token"), null, null);
        return view(theme('partials.category_paginate_data'), $data);
    }

    public function fetchFilterPagenateData(Request $request)
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
        $data['products'] = $this->filterService->filterProductFromCategoryBlade(session()->get('filterDataFromCat'), $sort_by, $paginate);
        return view(theme('partials.category_paginate_data'), $data);
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
        $data['products'] = $this->filterService->filterProductBlade($request->except("_token"), $sort_by, $paginate);
        if ($request->requestItemType == "category") {
            $data['category_id'] = $request->requestItem;
            $data['item'] = "category";
        }
        if ($request->requestItemType == "brand") {
            $data['brand_id'] = $request->requestItem;
            $data['item'] = "brand";
        }
        if ($request->requestItemType == "search") {
            $data['keyword'] = $request->requestItem;
            $data['item'] = "search";
        }
        if ($request->requestItemType == "tag") {
            $data['tag_id'] = $request->requestItem;
            $data['item'] = "tag";
        }
        if($request->requestItemType == "product"){
            $data['section_name'] = $request->requestItem;
            $data['item'] = "product";
        }

        return view(theme('partials.listing_paginate_data'),$data);
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
        $data['products'] = $this->filterService->filterProductBlade(session()->get('filterDataFromCat'), $sort_by, $paginate);
        if ($request->requestItemType == "category") {
            $data['category_id'] = $request->requestItem;
            $data['item'] = "category";
        }
        if ($request->requestItemType == "brand") {
            $data['brand_id'] = $request->requestItem;
            $data['item'] = "brand";
        }
        if ($request->requestItemType == "search") {
            $data['keyword'] = $request->requestItem;
            $data['item'] = "search";
        }
        if ($request->requestItemType == "tag") {
            $data['tag_id'] = $request->requestItem;
            $data['item'] = "tag";
        }
        return view(theme('partials.listing_paginate_data'), $data);
    }

    public function sortFilterIndexByType(Request $request)
    {

        if (session()->has('filterDataFromCat')) {
            $data['products'] = $this->filterService->filterSortProductBlade($request->except("_token"),session()->get('filterDataFromCat'));
        }
        else {
            $data['products'] = $this->filterService->productSortByCategory($request->requestItemType,$request->requestItem, $request->sort_by, $request->paginate);
        }
        if ($request->requestItemType == "category") {
            $data['category_id'] = $request->requestItem;
            $data['item'] = "category";
        }
        if ($request->requestItemType == "brand") {
            $data['brand_id'] = $request->requestItem;
            $data['item'] = "brand";
        }
        if ($request->requestItemType == "tag") {
            $data['tag_id'] = $request->requestItem;
            $data['item'] = "tag";
        }
        if ($request->requestItemType == 'product') {
            $data['item'] = 'product';
            $data['section_name'] = $request->requestItem;
        }
        if ($request->requestItemType == "search") {
            $data['keyword'] = $request->requestItem;
            $data['item'] = "search";
        }
        if ($request->has('sort_by')) {
            $data['sort_by'] = $request->sort_by;
        }
        if ($request->has('paginate')) {
            $data['paginate'] = $request->paginate;
        }
        return view(theme('partials.listing_paginate_data'), $data);
    }

    public function productByCategory(Request $request, $slug)
    {

        $request->validate([
            'item' => 'required'
        ]);
        $category_id = 0;
        $sort_by = null;
        $paginate = 9;
        $data = [];

        if ($request->has('sort_by')) {
            $sort_by = $request->sort_by;
            $data['sort_by'] = $request->sort_by;
        }
        if ($request->has('paginate')) {
            $paginate = $request->paginate;
            $data['paginate'] = $request->paginate;
        }
        $item = $request->item;
        if ($item == 'category') {
            $catRepo = new CategoryRepository(new Category());
            $category = $catRepo->findBySlug($slug);
            $category_id = $category->id;
            $data['CategoryList'] = $catRepo->subcategory($category_id);
            $data['filter_name'] = $catRepo->show($category_id);
            $category_ids = $catRepo->getAllSubSubCategoryID($category_id);

            $data['brandList'] = $this->filterService->filterBrandCategoryWise($category_id, $category_ids);

            $data['products'] = $this->filterService->filterProductCategoryWise($category_id, $category_ids, $sort_by, $paginate);
            
            $product_min_price = $this->filterService->filterProductMinPrice($data['products']->pluck('id'));
            $product_max_price = $this->filterService->filterProductMaxPrice($data['products']->pluck('id'));
            $product_min_price = $this->filterService->getConvertedMin($product_min_price);
            $product_max_price = $this->filterService->getConvertedMax($product_max_price);
            $data['min_price_lowest'] = $product_min_price;
            $data['max_price_highest'] = $product_max_price;

            $attributeRepo = new AttributeRepository;
            $data['attributeLists'] = $attributeRepo->getAttributeForSpecificCategory($category_id, $category_ids);
            $data['category_id'] = $category_id;
            $data['color'] = $attributeRepo->getColorAttributeForSpecificCategory($category_id, $category_ids);
        }

        if ($item == 'brand') {
            $brandRepo = new BrandRepository(new Brand());
            $brand = $brandRepo->findBySlug($slug);
            $brand_id = $brand->id;
            $data['filter_name'] = $brandRepo->find($brand_id);
            $data['brand_id'] = $brand_id;
            $data['products'] = $this->filterService->filterProductBrandWise($brand_id, $sort_by, $paginate);

            $product_min_price = $this->filterService->filterProductMinPrice($data['products']->pluck('id'));
            $product_max_price = $this->filterService->filterProductMaxPrice($data['products']->pluck('id'));
            $product_min_price = $this->filterService->getConvertedMin($product_min_price);
            $product_max_price = $this->filterService->getConvertedMax($product_max_price);
            $data['min_price_lowest'] = $product_min_price;
            $data['max_price_highest'] = $product_max_price;


            $data['CategoryList'] = $this->filterService->filterCategoryBrandWise($brand_id);
            $attributeRepo = new AttributeRepository;
            $data['attributeLists'] = $attributeRepo->getAttributeForSpecificBrand($brand_id);
            $data['color'] = $attributeRepo->getColorAttributeForSpecificBrand($brand_id);
        }
        if($item == 'product'){

            $result = $this->filterService->getSectionProducts($slug);
            $products = $result['products'];
            $section = $result['section'];

            $data['tag'] = $section->title;
            $data['item'] = $request->item;
            $data['section_name'] = $slug;
            $mainProducts = Product::where('status', 1)->whereHas('sellerProducts', function($q)use($products){
                return $q->whereIn('id',$products->pluck('id')->toArray());
            })->pluck('id')->toArray();
            $category_ids = CategoryProduct::whereIn('product_id',$mainProducts)->distinct()->pluck('category_id')->toArray();
            $data['CategoryList'] = Category::whereIn('id',$category_ids)->where('parent_id',0)->get()->take(10);
            $brandIds = Product::whereIn('id',$mainProducts)->distinct()->pluck('brand_id');
            $data['brandList'] = Brand::whereIn('id',$brandIds)->get()->take(10);
            $attribute_ids = ProductVariations::whereIn('product_id',$mainProducts)->distinct()->pluck('attribute_id');
            $data['attributeLists'] =  Attribute::with('values')->whereIn('id', $attribute_ids)->where('id','>',1)->get()->take(1);
            $data['color'] = Attribute::with('values')->whereIn('id',$attribute_ids)->where('id',1)->first();
            $data['products'] = $this->filterService->sortAndPaginate($products, $sort_by, $paginate);

            $product_min_price = $this->filterService->filterProductMinPrice($products->pluck('id'));
            $product_max_price = $this->filterService->filterProductMaxPrice($products->pluck('id'));

            $product_min_price = $this->filterService->getConvertedMin($product_min_price);
            $product_max_price = $this->filterService->getConvertedMax($product_max_price);

            

            $data['min_price_lowest'] = $product_min_price;
            $data['max_price_highest'] = $product_max_price;

        }

        if ($item == 'tag') {

            $tag = Tag::where('name',$slug)->first();

            $mainProducts = ProductTag::where('tag_id', $tag->id)->pluck('product_id')->toArray();
            $data['tag'] = $tag->name;
            $data['tag_id'] = $tag->name;
            $category_ids = CategoryProduct::whereIn('product_id',$mainProducts)->distinct()->pluck('category_id');
            $data['CategoryList'] = Category::whereIn('id',$category_ids)->get();
            $brandIds = Product::whereIn('id',$mainProducts)->distinct()->pluck('brand_id')->toArray();
            $data['brandList'] = Brand::whereIn('id',$brandIds)->get();
            $attribute_ids = ProductVariations::whereIn('product_id',$mainProducts)->distinct()->pluck('attribute_id');
            $data['attributeLists'] =  Attribute::with('values')->whereIn('id', $attribute_ids)->where('id','>',1)->get();
            $data['color'] = Attribute::with('values')->whereIn('id',$attribute_ids)->first();

            $products = SellerProduct::where('status', 1)->whereHas('product', function($query) use($mainProducts){
                return $query->whereIn('product_id',$mainProducts);
            })->activeSeller()->get();

            $giftCards = GiftCard::where('status', 1)->whereHas('tags', function($q) use($tag){
                return $q->where('tag_id', $tag->id);

            })->select(['*', 'name as product_name','sku as slug'])->where('status', 1)->get();

            $product_min_price = $this->filterService->filterProductMinPrice($products->pluck('id'));
            $product_max_price = $this->filterService->filterProductMaxPrice($products->pluck('id'));

            $giftcard_min_price = $giftCards->min('selling_price');
            $giftcard_max_price = $giftCards->max('selling_price');


            $products = $products->merge($giftCards);

            $min_price = $this->filterService->getConvertedMin(min($product_min_price,$giftcard_min_price));
            $max_price = $this->filterService->getConvertedMax(max($product_max_price,$giftcard_max_price));

            

            $data['min_price_lowest'] = $min_price;
            $data['max_price_highest'] = $max_price;

            $data['products'] = $this->filterService->sortAndPaginate($products, $sort_by, $paginate);
        }

        if ($item == 'search') {

            $searchTerm = SearchTerm::where('keyword',$slug)->first();
            if($searchTerm){
                $count = $searchTerm->count;
                $searchTerm->count = 1+$count;

                $searchTerm->save();
            }else{
                SearchTerm::create(['keyword'=>$slug,'count'=>1]);
            }

            $data['filter_name'] = "Search Query : ". "\" ". $slug. " \" ";

            $slugs = explode(' ',$slug);

            $mainProducts = Product::whereHas('tags', function($q) use($slugs){

                return $q->where(function($q) use ($slugs){
                    foreach($slugs as $slug){
                        $q = $q->orWhere('name', 'LIKE', "%{$slug}%");
                    }
                    return $q;
                });

            })->pluck('id')->toArray();

            $giftCards = GiftCard::where('status', 1)->whereHas('tags', function($q) use($slugs){
                return $q->where(function($q) use ($slugs){
                    foreach($slugs as $slug){
                        $q = $q->orWhere('name', 'LIKE', "%{$slug}%");
                    }
                    return $q;
                });

            })->select(['*', 'name as product_name','sku as slug'])->get();


            $category_ids = CategoryProduct::whereIn('product_id',$mainProducts)->distinct()->pluck('category_id');
            $data['CategoryList'] = Category::whereIn('id',$category_ids)->get();




            $products = SellerProduct::where('status', 1)->whereHas('product', function($query) use($mainProducts,$slug){
                return $query->whereIn('id',$mainProducts)->orWhere('product_name','LIKE', "%{$slug}%");
            })->orWhere('product_name', 'LIKE', "%{$slug}%")->activeSeller()->get();


            $brandIds = Product::whereIn('id',$mainProducts)->distinct()->pluck('brand_id');
            $data['brandList'] = Brand::whereIn('id',$brandIds)->get();
            $attribute_ids = ProductVariations::whereIn('product_id',$mainProducts)->distinct()->pluck('attribute_id');
            $data['attributeLists'] =  Attribute::with('values')->whereIn('id', $attribute_ids)->where('id','>',1)->get();
            $data['color'] = Attribute::with('values')->whereIn('id',$attribute_ids)->first();

            $product_min_price = $this->filterService->filterProductMinPrice($products->pluck('id'));
            $product_max_price = $this->filterService->filterProductMaxPrice($products->pluck('id'));
            $giftcard_min_price = $giftCards->min('selling_price');
            $giftcard_max_price = $giftCards->max('selling_price');



            $min_price = $this->filterService->getConvertedMin(min($product_min_price,$giftcard_min_price));
            $max_price = $this->filterService->getConvertedMax(max($product_max_price,$giftcard_max_price));

            $data['min_price_lowest'] = $min_price;
            $data['max_price_highest'] = $max_price;

            $products = $products->merge($giftCards);

            $data['keyword'] = $slug;
            $data['products'] = $this->filterService->sortAndPaginate($products, $sort_by, $paginate);
        }

        if (!$request->has('page')) {
            $data['products']->appends($request->except('page'));
            if (session()->has('filterDataFromCat')) {
                session()->forget('filterDataFromCat');
            }
            return view(theme('pages.listing'),$data);
        }
        else {
            return  view(theme('partials.listing_paginate_data'),$data);
        }
    }

    public function get_colors_by_type(Request $request)
    {
        if ($request->type == "cat") {
            $catRepo = new CategoryRepository(new Category());
            $category_ids = $catRepo->getAllSubSubCategoryID($request->id);
            $attributeRepo = new AttributeRepository;
            $data['color'] = $attributeRepo->getColorAttributeForSpecificCategory($request->id, $category_ids);
        }
        if ($request->type == "brand") {
            $attributeRepo = new AttributeRepository;
            $data['color'] = $attributeRepo->getColorAttributeForSpecificBrand($request->id);
        }
        return view(theme('partials.color_attribute'), $data);
    }

    public function get_brand_by_type(Request $request)
    {
        if ($request->type == "cat") {
            $catRepo = new CategoryRepository(new Category());
            $category_ids = $catRepo->getAllSubSubCategoryID($request->id);
            $brandRepo = new BrandRepository;
            $data['brandList'] = $brandRepo->getBrandForSpecificCategory($request->id, $category_ids);
        }
        return view(theme('partials.brand'), $data);
    }

    public function get_attribute_by_type(Request $request)
    {
        if ($request->type == "cat") {
            $catRepo = new CategoryRepository(new Category());
            $category_ids = $catRepo->getAllSubSubCategoryID($request->id);
            $attributeRepo = new AttributeRepository;
            $data['attributeLists'] = $attributeRepo->getAttributeForSpecificCategory($request->id, $category_ids);
        }
        if ($request->type == "brand") {
            $attributeRepo = new AttributeRepository;
            $data['attributeLists'] = $attributeRepo->getAttributeForSpecificBrand($request->id);
        }
        return view(theme('partials.attributes'), $data);
    }
}
