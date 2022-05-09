<?php
namespace Modules\Product\Repositories;

use App\Repositories\FilterRepository;
use Modules\GiftCard\Entities\GiftCard;
use Modules\Product\Entities\Attribute;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\CategoryProduct;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductTag;
use Modules\Product\Entities\ProductVariations;
use Modules\Seller\Entities\SellerProduct;
use Modules\Setup\Entities\Tag;

class TagRepository
{

    public function tagList(){
        return Tag::latest()->paginate(10);
    }

    public function getByTag($tag){
        $tag = Tag::where('name', $tag)->orWhere('id', $tag)->first();
        if($tag){
            $data['tag'] = $tag;
            $mainProducts = ProductTag::where('tag_id', $tag->id)->pluck('product_id')->toArray();
            $category_ids = CategoryProduct::whereIn('product_id',$mainProducts)->distinct()->pluck('category_id');
            $data['CategoryList'] = Category::whereIn('id',$category_ids)->get();
            $brandIds = Product::whereIn('id',$mainProducts)->distinct()->pluck('brand_id')->toArray();
            $data['brandList'] = Brand::whereIn('id',$brandIds)->get();
            $attribute_ids = ProductVariations::whereIn('product_id',$mainProducts)->distinct()->pluck('attribute_id');
            $data['attributeLists'] =  Attribute::with('values')->whereIn('id', $attribute_ids)->where('id','>',1)->get();
            $data['color'] = Attribute::with('values')->whereIn('id',$attribute_ids)->first();
            $products = SellerProduct::with('product')->where('status', 1)->whereHas('product', function($query) use($mainProducts){
                return $query->whereIn('product_id',$mainProducts);
            })->activeSeller()->get();

            $giftCards = GiftCard::where('status', 1)->whereHas('tags', function($q) use($tag){
                return $q->where('tag_id', $tag->id);

            })->select(['*', 'name as product_name','sku as slug'])->where('status', 1)->get();
            $filterRepo = new FilterRepository();
            $product_min_price = $filterRepo->filterProductMinPrice($products->pluck('id'));
            $product_max_price = $filterRepo->filterProductMaxPrice($products->pluck('id'));

            $giftcard_min_price = $giftCards->min('selling_price');
            $giftcard_max_price = $giftCards->max('selling_price');

            $data['min_price'] = (min($product_min_price,$giftcard_min_price) != null)?min($product_min_price,$giftcard_min_price):0;
            $data['max_price'] = max($product_max_price,$giftcard_max_price);

            $products = $products->merge($giftCards);

            $data['products'] = $products->paginate(10);
            return $data;
        }else{
            return false;
        }
        
    }

}
