<?php
namespace Modules\Seller\Repositories;

use App\Models\Cart;
use App\Models\User;
use App\Traits\GenerateSlug;
use App\Traits\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\MultiVendor\Entities\SellerAccount;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductSku;
use Modules\Product\Entities\ProductVariations;
use Modules\Seller\Entities\SellerProduct;
use Modules\Seller\Entities\SellerProductSKU;

use Modules\FrontendCMS\Entities\HomePageSection;
use Modules\GeneralSetting\Entities\EmailTemplateType;
use Modules\MultiVendor\Entities\SellerBankAccount;
use Modules\MultiVendor\Entities\SellerBusinessInformation;
use App\Traits\ImageStore;

class ProductRepository {

    use Notification;
    use ImageStore;
    use GenerateSlug;

    protected $seller;
    protected $productSku;

    public function __construct(User $seller, SellerProduct $product){
        $this->seller = $seller;
        $this->product = $product;
    }

    public function getAll(){
        if(auth()->check() && auth()->user()->role->type == 'seller'){
            if(auth()->user()->sub_seller){
                return $this->product::with('product','skus')->where('user_id',auth()->user()->sub_seller->seller_id);
            }else{
                return $this->product::with('product','skus')->where('user_id',auth()->user()->id);
            }
        }elseif (auth()->check() && auth()->user()->role->type == "superadmin" || auth()->check() && auth()->user()->role->type == "admin" || auth()->check() && auth()->user()->role->type == "staff") {
            return $this->product::with('product','skus')->where('user_id',User::first()->id);
        }else{
            return abort(404);
        }
    }

    public function getRecomandedProduct(){
        $section = HomePageSection::where('section_name', 'more_products')->first();
        return $section->getApiProductByQuery();
    }

    public function getTopPicks(){
        $section = HomePageSection::where('section_name', 'top_picks')->first();
        return $section->getApiProductByQuery();
    }

    public function getAllSellerProduct(){

        return SellerProduct::with('product', 'seller', 'reviews.customer', 'reviews.images', 'product.brand','product.categories','product.unit_type',
        'product.variations','product.skus', 'product.tags','product.gallary_images','product.relatedProducts.related_seller_products',
        'product.upSales.up_seller_products', 'product.crossSales.cross_seller_products','product.shippingMethods.shippingMethod')->where('status', 1)->paginate(10);
    }

    public function getSellerProductById($id){
        return SellerProduct::with('product','seller', 'reviews.customer', 'reviews.images', 'product.brand','product.categories','product.unit_type',
        'product.variations','product.skus', 'product.tags','product.gallary_images','product.relatedProducts.related_seller_products.product',
        'product.upSales.up_seller_products.product', 'product.crossSales.cross_seller_products.product','product.shippingMethods.shippingMethod')->where('status', 1)->where('id', $id)->first();
    }

    public function getMyProducts(){
        if(auth()->check() && auth()->user()->role->type == 'seller'){
            $seller_id = getParentSellerId();
            return Product::with('product','skus')->where('created_by',$seller_id)->latest()->get();
        }else{
            return abort(404);
        }
    }
    public function getFilterdProduct($data){

        if($data['table'] == 'alert'){
            return $this->product::where('stock_manage',1)->where('user_id',auth()->user()->id)->whereHas('skus', function($query){
                return $query->select(DB::raw('SUM(product_stock) as sum_colum'))->having('sum_colum', '<=', 10);
            });
        }
        if($data['table'] == 'stockout'){
            return $this->product::where('stock_manage',1)->where('user_id',auth()->user()->id)->whereHas('skus', function($query){
                return $query->select(DB::raw('SUM(product_stock) as sum_colum'))->having('sum_colum', '<', 1);
            });
        }
        if($data['table'] == 'disable'){
            return $this->product::where('status',0)->where('user_id',auth()->user()->id);
        }

    }


    public function getAllProduct(){
        return Product::where('is_approved',1)->where('status', 1)->get();
    }

    public function getProductOfOtherSeller(){
        $sellerProductIds = SellerProduct::where('user_id',auth()->id())->pluck('product_id');
        return Product::whereNotIn('id',$sellerProductIds)->where('is_approved',1)->where('status', 1)->get();
    }

    public function getProduct($id){

        $is_exsists = SellerProduct::where('user_id', auth()->user()->id)->where('product_id', $id)->first();
        if($is_exsists){
            return 'product_exsist';
        }else{
            return Product::with('skus', 'activeSkus')->where('id',$id)->firstOrFail();
        }
    }
    public function statusChange($data, $id){
        return $this->product->findOrFail($id)->update([
            'status' => $data['status']
        ]);
    }


    public function store($data){
        $product = Product::where('id',$data['product_id'])->firstOrFail();

        $seller_id = getParentSellerId();
        $productName = (!empty($data['product_name'])) ? $data['product_name'].'-'.$seller_id : $product->product_name;
        $sellerProduct =  $this->product::create([
            'product_id' => $data['product_id'],
            'tax' => isset($data['tax'])?$data['tax']:0,
            'tax_type' => $data['tax_type'],
            'product_name' => (!empty($data['product_name'])) ? $data['product_name'] : $product->product_name,
            'thum_img' => (!empty($data['thum_img_src'])) ? $data['thum_img_src'] : null,
            'discount' => isset($data['discount'])?$data['discount']:0,
            'discount_type' => $data['discount_type'],
            'is_digital' => ($product->is_physical == 0) ? 0 : 1,
            'discount_start_date' => date('Y-m-d',strtotime($data['discount_start_date'])),
            'discount_end_date' => date('Y-m-d',strtotime($data['discount_end_date'])),
            'stock_manage' => (!empty($data['stock_manage'])) ? $data['stock_manage'] : 0,
//            'slug' => (!empty($data['product_name'])) ? preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(array(':', '\\', '/', '*', ' '),'-',$data['product_name'])).'-'.$seller_id) : preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(array(':', '\\', '/', '*', ' '),'-',$product->product_name)).'-'.$seller_id),
            'slug' => $this->productSlug($productName),
            'user_id' => $seller_id
        ]);
        if($product->product_type == 1){
            SellerProductSKU::create([
                'product_id' => $sellerProduct->id,
                'product_sku_id' => $product->skus->first()->id,
                'product_stock' => ($data['stock_manage'] == 1) ? $data['product_stock'] : 0,
                'selling_price' => $data['selling_price'],
                'status' => 1,
                'user_id' => $seller_id
            ]);
        }
        if($product->product_type == 2){

            foreach($data['selling_price_sku'] as $key => $item){
                SellerProductSKU::create([
                    'product_id' => $sellerProduct->id,
                    'product_sku_id' => $data['product_skus'][$key],
                    'product_stock' => ($data['stock_manage'] == 1) ? $data['stock'][$key] : 0,
                    'selling_price' => $data['selling_price_sku'][$key],
                    'status' => 1,
                    'user_id' => $seller_id
                ]);
            }
        }
        $sellerProduct->update([
            'min_sell_price' => $sellerProduct->skus->min('selling_price'),
            'max_sell_price' => $sellerProduct->skus->max('selling_price')
        ]);
        return 1;
    }

    public function findById($id){
        return $this->product::with('skus')->where('product_id',$id)->firstOrFail();
    }

    public function findBySellerProductId($id){
        return SellerProduct::with('skus')->findOrFail($id);
    }

    public function deleteById($id){

        $product =  $this->product->findOrFail($id);

        if(count($product->flashDealProducts) > 0 || count($product->newUserZoneProducts) > 0 ||
            count($product->MenuElements) > 0 || $product->headerProductPanel != null || count($product->Silders) > 0 ||
            count($product->homepageCustomProducts) > 0 || count($product->Orders) > 0){
            return 'not_possible';
        }else{
            $skus = $product->skus->pluck('id')->toArray();
            $cart_list = Cart::where('product_type','product')->whereIn('product_id', $skus)->pluck('id')->toArray();
            Cart::destroy($cart_list);

            ImageStore::deleteImage($product->thum_img);
            $product->delete();
            return 'possible';
        }
    }

    public function update($data, $id){
        $product =  $this->product::findOrFail($id);
        $product->update([
            'tax' => isset($data['tax'])?$data['tax']:0,
            'tax_type' => $data['tax_type'],
            'discount' => isset($data['discount'])?$data['discount']:0,
            'discount_type' => $data['discount_type'],
            'discount_start_date' => date('Y-m-d',strtotime($data['discount_start_date'])),
            'discount_end_date' => date('Y-m-d',strtotime($data['discount_end_date'])),
            'stock_manage' => (!empty($data['stock_manage'])) ? $data['stock_manage'] : 0,
            'product_name' => (!empty($data['product_name'])) ? $data['product_name'] : $product->product->product_name,
            'thum_img' => isset($data['thum_img_src'])?$data['thum_img_src']: $product->thum_img
        ]);
        if($product->seller->role->type == 'superadmin'){
            $product->product->update([
                'stock_manage' => (!empty($data['stock_manage'])) ? $data['stock_manage'] : 0
            ]);
        }
        if($product->product->product_type == 1){
            $product->skus->first()->update([
                'product_stock' => ($product->stock_manage == 1) ? $data['product_stock'] : 0,
                'selling_price' => $data['selling_price'],
            ]);
            if($product->seller->role->type == 'superadmin'){
                $product->product->skus->first()->update([
                    'product_stock' => ($product->stock_manage == 1) ? $data['product_stock'] : 0
                ]);
            }
        }
        if($product->product->product_type == 2){
            foreach($data['product_skus'] as $key => $item){
                $variant = SellerProductSKU::where('product_sku_id',$item)->where('user_id', auth()->user()->id)->first();
                if(isset($variant)){
                    $variant->update([
                        'product_stock' => ($product->stock_manage == 1) ? $data['stock'][$key]??0 : 0,
                        'selling_price' => $data['selling_price_sku'][$key],
                        'status' => isset($data['status_'.$item])?1:0
                    ]);
                }
                else{
                    SellerProductSKU::create([
                        'product_id' => $product->id,
                        'product_sku_id' => $data['product_skus'][$key],
                        'product_stock' => ($product->stock_manage == 1) ? $data['stock'][$key]??0 : 0,
                        'selling_price' => $data['selling_price_sku'][$key],
                        'status' => isset($data['status_'.$item])?1:0,
                        'user_id' => getParentSellerId()
                    ]);
                }
                if($product->seller->role->type == 'superadmin'){
                    ProductSku::find($item)->update([
                        'product_stock' => ($product->stock_manage == 1) ? $data['stock'][$key]??0 : 0
                    ]);
                }
            }

        }

         // Send Notification
         $this->notificationUrl = route('seller.product.index');
         $this->typeId = EmailTemplateType::where('type', 'product_update_email_template')->first()->id;
         $users = User::whereHas('role', function($query){
             return $query->where('type', 'superadmin');
         })->pluck('id');
         foreach($users as $user){
             $this->notificationSend("Seller product update", $user);
         }

        return 1;
    }
    public function variantDelete($id){
        return SellerProductSKU::findOrFail($id)->delete();
    }

    public function getVariantByProduct($data){
        return ProductSku::where('id',$data['id'])->firstOrFail();
    }
    public function getThisSKUProduct($id){
        $sellerProduct = SellerProduct::findOrFail($id);
        $skunotin = SellerProductSKU::where('product_id',$id)->pluck('product_sku_id');

        return ProductSku::where('product_id',$sellerProduct->product->id)->where('status', 1)->whereNotIn('id',$skunotin)->get();
    }

    public function stockManageStatus($data){
        return SellerProduct::findOrFail($data['id'])->update([
            'stock_manage' => $data['status']
        ]);
    }

    public function getSellerBusinessInfo(){
        return SellerBusinessInformation::with('country', 'state', 'city')->where('user_id', auth()->user()->id)->first();
    }

    public function getSellerBankInfo(){
        return SellerBankAccount::where('user_id', auth()->user()->id)->first();
    }

    public function get_seller_product_sku_wise_price($data){
        $array = [];
        if (count($data) > 0) {
            foreach ($data['id'] as $key => $id) {
                array_push($array,explode('-',$id));
            }
        }

        $a = SellerProductSKU::query()->with('product.product');
        foreach ($array as $key => $value) {
            $a->where('user_id', $data['user_id'])->where('product_id', $data['product_id'])->whereHas('product_variations', function($query) use ($value){
                $query->where('attribute_id', $value[1])->where('attribute_value_id', $value[0]);
            });
        }
        if ($a->first()) {
            return response()->json([
                'data' => $a->with('sku','product')->first(),
            ]);
        }else {
            return 0;
        }
    }
}
