<?php

namespace Modules\Product\Imports;

use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductSku;
use Modules\Product\Entities\ProductTag;
use Modules\Shipping\Entities\ProductShipping;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Product\Entities\CategoryProduct;
use Modules\Seller\Entities\SellerProduct;
use Modules\Seller\Entities\SellerProductSKU;

class ProductImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $product = Product::create([
                'id'    => $row['id'],
                'product_name'    => $row['product_name'],
                'product_type'    => 1,
                'unit_type_id'    => $row['unit_type_id'],
                'brand_id'    => $row['brand_id'],
                'model_number'    => $row['model_number'],
                'shipping_cost'    => $row['shipping_cost'],
                'discount_type'    => $row['discount_type'],
                'discount'    => $row['discount'],
                'tax_type'    => $row['tax_type'],
                'tax'    => $row['tax'],
                'description'    => $row['description'],
                'specification'    => $row['specification'],
                'minimum_order_qty'    => $row['minimum_order_qty'],
                'meta_title'    => $row['meta_title'],
                'meta_description'    => $row['meta_description'],
                'slug'    => $row['slug'],
                'is_approved' => 1
            ]);
            $tags = explode(',', $row['tags']);
            foreach ($tags as $key => $tag) {
                $product_tag = new ProductTag;
                $product_tag->product_id = $product->id;
                $product_tag->tag_id = $tag;
                $product_tag->save();
            }

            $category_ids = explode(',', $row['category_id']);
            foreach ($category_ids as $key => $category_id) {
                $category_product = new CategoryProduct();
                $category_product->product_id = $product->id;
                $category_product->category_id = $category_id;
                $category_product->save();
            }

            ProductShipping::create([
                'shipping_method_id' => 2,
                'product_id' => $product->id
            ]);

            $product_sku = new ProductSku;
            $product_sku->product_id = $product->id;
            $product_sku->sku = $row['sku'];
            $product_sku->selling_price = $row['selling_price'];

            $product_sku->additional_shipping = $row['additional_shipping'];
            $product_sku->status = 1;
            $product_sku->save();

            $sellerProduct = SellerProduct::create([
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'stock_manage' => 0,
                'tax' => $product->tax,
                'tax_type' => $product->tax_type,
                'discount' => $product->discount,
                'discount_type' => $product->discount_type,
                'is_digital' => 0,
                'user_id' => 1,
                'slug' => strtolower(str_replace(' ', '-', $product->product_name)).'-'.rand(111,999) . '-' . 1,
                'is_approved' => 1,
                'status' => 1
            ]);

            SellerProductSKU::create([
                'user_id' => 1,
                'product_id' => $sellerProduct->id,
                'product_sku_id' => $product_sku->id,
                'selling_price' => $product_sku->selling_price,
                'status' => 1
            ]);
        }
    }
}
