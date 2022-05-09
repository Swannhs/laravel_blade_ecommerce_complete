<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\SearchTerm;
use App\Models\RecentViewProduct;
use Modules\Seller\Entities\SellerProduct;
use Modules\Product\Entities\Product;
use Modules\GiftCard\Entities\GiftCard;
use Modules\Product\Entities\Category;
use Carbon\Carbon;
use Modules\Review\Entities\ProductReview;

class BackupProductRepository{

    protected $product;

    public function __construct(SellerProduct $product){
        $this->product = $product;
    }

    public function getProductByID($id){
        return $this->product::with('product','skus')->where('id',$id)->firstOrFail();
    }

    public function recentViewedProducts($product_ids)
    {
        return $this->product::with('product','skus')->whereIn('id',$product_ids)->latest()->get();
    }

    public function getProductBySlug($slug)
    {
        return $this->product::with('product','skus')->where('slug',$slug)->firstOrFail();
    }

    public function recentViewIncrease($id){
        $sellerProduct = $this->getProductByID($id);
        return $sellerProduct->update([
            'recent_view' => Carbon::now(),
        ]);
    }

    public function recentViewStore($seller_product_id)
    {
        $total_products = RecentViewProduct::where('user_id', auth()->user()->id)->get();
        if (count($total_products) == app('recently_viewed_config')['max_limit']) {
            $old_product = RecentViewProduct::where('user_id', auth()->user()->id)->first()->delete();
        }
        $infoExist = RecentViewProduct::where('user_id', auth()->user()->id)->where('seller_product_id', $seller_product_id)->first();
        if ($infoExist) {
            return $infoExist->update([
                'viewed_at' => date('y-m-d')
            ]);
        }
        else {
            return RecentViewProduct::create([
                'user_id' => auth()->user()->id,
                'seller_product_id' => $seller_product_id,
                'viewed_at' => date('y-m-d')
            ]);
        }
    }

    public function lastRecentViewinfo()
    {
        return RecentViewProduct::where('user_id', auth()->user()->id)->latest()->get()->pluck('seller_product_id');
    }

    public function getReviewByPage($data){
        return ProductReview::where('product_id', $data['product_id'])->latest()->paginate(10);
    }

    public function searchProduct($request)
    {
        $is_single = 0;
        $giftcard_result = collect();
        if($request['cat_id'] != 0){
            $category_ids = DB::table('categories')->where('status', 1)->where('parent_id', $request['cat_id'])->pluck('id');
            if (count($category_ids) == 0) {
                $category = Category::where('id', $request['cat_id'])->first();
                if ($category) {
                    $category_id = $category->id;
                    $is_single = 1;
                }
            }
        }else {
            $category_ids = DB::table('categories')->where('status', 1)->pluck('id');
        }
        if ($is_single == 1) {
            if ($request['keyword'] != null) {
                $product_id_from_tag_table = DB::table('product_tags')->where('tag','LIKE',"%{$request['keyword']}%")->pluck('product_id');
                $result = DB::table('seller_products')
                            ->join('products','products.id','seller_products.product_id')
                            ->join('product_tags','product_tags.id','seller_products.product_id')
                            ->whereIn('products.category_id', [$category_id])
                            ->where('seller_products.product_name','LIKE',"%{$request['keyword']}%")
                            ->orWhereIn('seller_products.product_id', $product_id_from_tag_table)
                            ->select('seller_products.product_name as product_name', 'seller_products.slug as slug')
                            ->inRandomOrder()
                            ->limit(6)
                            ->get();
            }else {
                $result = DB::table('seller_products')
                            ->join('products','products.id','seller_products.product_id')
                            ->whereIn('products.category_id', [$category_id])
                            ->select('seller_products.product_name as product_name', 'seller_products.slug as slug')
                            ->inRandomOrder()
                            ->limit(6)
                            ->get();
            }
        }else {
            if ($request['keyword'] != null) {
                $product_id_from_tag_table = DB::table('product_tags')->where('tag','LIKE',"%{$request['keyword']}%")->pluck('product_id');
                $result = DB::table('seller_products')
                            ->join('products','products.id','seller_products.product_id')
                            ->join('product_tags','product_tags.id','seller_products.product_id')
                            ->whereIn('products.category_id', $category_ids)
                            ->where('seller_products.product_name','LIKE',"%{$request['keyword']}%")
                            ->orWhereIn('seller_products.product_id', $product_id_from_tag_table)
                            ->select('seller_products.product_name as product_name', 'seller_products.slug as slug')
                            ->inRandomOrder()
                            ->limit(6)
                            ->get();
            }else {
                $result = DB::table('seller_products')
                            ->join('products','products.id','seller_products.product_id')
                            ->whereIn('products.category_id', $category_ids)
                            ->select('seller_products.product_name as product_name', 'seller_products.slug as slug')
                            ->inRandomOrder()
                            ->limit(6)
                            ->get();
            }
        }
        if ($request['keyword'] != null) {
            $giftcard_result = DB::table('gift_cards')
                        ->where('name','LIKE',"%{$request['keyword']}%")
                        ->select('gift_cards.name as gift_card_name', 'gift_cards.sku as gift_card_slug')
                        ->inRandomOrder()
                        ->limit(2)
                        ->get();
        }
        $data['productData'] = $result;
        $data['giftData'] = $giftcard_result;
        return $data;
    }
}
