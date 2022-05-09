<?php

namespace Modules\Product\Repositories;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Color;
use Modules\Product\Entities\Attribute;
use Modules\Product\Entities\AttributeValue;
use Modules\Product\Entities\ProductVariations;
use Modules\Seller\Entities\SellerProduct;
use Modules\Seller\Entities\SellerProductSKU;

class AttributeRepository
{
    public function getAll()
    {
        return Attribute::latest()->get();
    }

    public function getActiveAll()
    {
        return Attribute::with('values')->latest()->Active()->get();
    }

    public function getActiveAllWithoutColor()
    {
        return Attribute::with('values')->where('id', '!=', 1)->latest()->Active()->get();
    }

    public function getColorAttr()
    {
        return Attribute::with('values')->where('id', 1)->first();
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        $variant = new Attribute();
        $variant->fill($data)->save();
        $variant_values = [];
        if ($data['variant_values']) {
            foreach ($data['variant_values'] as $value) {
                if ($value) {
                    $variant_values [] = [
                        "value" => $value,
                        "attribute_id" => $variant->id,
                        "created_at" => Carbon::now()
                    ];
                }
            }
            AttributeValue::insert($variant_values);
        }
        DB::commit();
    }

    public function find($id)
    {
        return Attribute::with('values', 'values.color')->findOrFail($id);
    }

    public function update(array $data, $id)
    {
        DB::beginTransaction();
        $variant = Attribute::findOrFail($id);
        $variant->update([
           'name' => $data['name'], 
           'description' => $data['description'],
           'status' => $data['status']
        ]);
        $collection1 = collect($data['edit_variant_values']);
        $collection2 = collect($variant->values->pluck('value','id'));
        $newDifferentItems = $collection1->diff($collection2);
        $new_variant_values = $newDifferentItems->all();
        $variant_values = [];
        if ($variant->id != 1 && $data['edit_variant_values']) {
            
            if(count($new_variant_values) > 0) {
                foreach ($new_variant_values as $key => $new_variant_value) {
                    AttributeValue::updateOrCreate([
                        'value' => $new_variant_value,
                        "attribute_id" => $variant->id
                    ]);
                }
            }else {
                $differentItems = $collection2->diff($collection1);
                $old_variant_values = $differentItems->all();
                if (count($old_variant_values) > 0) {
                    foreach ($old_variant_values as $key => $old_variant_value) {
                        $exixt_product = ProductVariations::where('attribute_value_id', $key)->first();
                        if ($exixt_product == null) {
                            AttributeValue::find($key)->delete();
                        }
                    }
                }
            }
        }else {
            if (count($new_variant_values) > 0) {
                foreach ($new_variant_values as $key => $new_variant_value) {
                    $attribute_val = new AttributeValue;
                    $attribute_val->value = $new_variant_value;
                    $attribute_val->attribute_id = $variant->id;
                    $attribute_val->created_at = Carbon::now();
                    $attribute_val->updated_at = Carbon::now();
                    $attribute_val->save();
                    $color = new Color;
                    $color->attribute_value_id = $attribute_val->id;
                    $color->name = $data['edit_variant_c_name'][$key];
                    $color->save();
                }
            }else {
                $differentItems = $collection2->diff($collection1);
                $old_variant_values = $differentItems->all();
                if (count($old_variant_values) > 0) {
                    foreach ($old_variant_values as $key => $old_variant_value) {
                        $exixt_product = ProductVariations::where('attribute_value_id', $key)->first();
                        if ($exixt_product == null) {
                            AttributeValue::find($key)->delete();
                        }
                    }
                }
            }
        }
        DB::commit();
    }

    public function delete($id)
    {
        $attribute = Attribute::findOrFail($id);
        if(ProductVariations::where('attribute_id', $id)->first() == null)
        {
            $attribute->values()->delete();
            $attribute->delete();
        }
        else {
            return "not_possible";
        }
    }

    public function getAttributeForSpecificCategory($category_id, $category_ids)
    {
        $seller_products = SellerProductSKU::whereHas('product', function($query) use($category_ids, $category_id){
            $query->where('status',1)->whereHas('product',function($query) use($category_ids, $category_id){
                return $query->WhereHas('categories',function($q1)use($category_ids,$category_id){
                    $q1->where('category_id',$category_id)->orWhereHas('subCategories', function($q2) use($category_ids){
                        $q2->whereIn('id',$category_ids);
                    });
                });
            });
        })->get();
        $product_skus = $seller_products->unique('product_sku_id')->pluck('product_sku_id');
        $attribute_ids = ProductVariations::whereIn('product_sku_id', $product_skus)->where('attribute_id', '!=', 1)->get()->pluck('attribute_id');
        $attribute_value_ids = ProductVariations::whereIn('product_sku_id', $product_skus)->where('attribute_id', '!=', 1)->get()->pluck('attribute_value_id');
        $attribute_list = Attribute::with('values')->whereIn('id', $attribute_ids)->get();
        return $attribute_list;
    }

    public function getColorAttributeForSpecificCategory($category_id, $category_ids)
    {
        $seller_products = SellerProductSKU::whereHas('product', function($query) use($category_ids, $category_id){
            $query->where('status',1)->whereHas('product',function($query) use($category_ids, $category_id){
                return $query->WhereHas('categories',function($q1) use($category_ids, $category_id){
                    $q1->where('category_id', $category_id)->orWhereHas('subCategories', function($q2)use($category_ids){
                        $q2->whereIn('id', $category_ids);
                    });
                });
            });
        })->get();
        $product_skus = $seller_products->unique('product_sku_id')->pluck('product_sku_id');
        $attribute_ids = ProductVariations::whereIn('product_sku_id', $product_skus)->where('attribute_id', 1)->get()->pluck('attribute_id');
        $attribute_value_ids = ProductVariations::whereIn('product_sku_id', $product_skus)->where('attribute_id', 1)->get()->pluck('attribute_value_id');
        $attribute_list = Attribute::with('values')->whereIn('id', $attribute_ids)->first();
        return $attribute_list;
    }

    public function getColorAttributeForSpecificBrand($brand_id)
    {
        $seller_products = SellerProductSKU::whereHas('product', function($query) use($brand_id){
            $query->where('status',1)->whereHas('product',function($query) use($brand_id){
                return $query->where('brand_id',$brand_id);
            });
        })->get();
        $product_skus = $seller_products->unique('product_sku_id')->pluck('product_sku_id');
        $attribute_ids = ProductVariations::whereIn('product_sku_id', $product_skus)->where('attribute_id', 1)->get()->pluck('attribute_id');
        $attribute_value_ids = ProductVariations::whereIn('product_sku_id', $product_skus)->where('attribute_id', 1)->get()->pluck('attribute_value_id');
        $attribute_list = Attribute::with('values')->whereIn('id', $attribute_ids)->first();
        return $attribute_list;
    }

    public function getAttributeForSpecificBrand($brand_id)
    {
        $seller_products = SellerProductSKU::whereHas('product', function($query) use($brand_id){
            $query->where('status',1)->whereHas('product',function($query) use($brand_id){
                return $query->where('brand_id',$brand_id);
            });
        })->get();
        $product_skus = $seller_products->unique('product_sku_id')->pluck('product_sku_id');
        $attribute_ids = ProductVariations::whereIn('product_sku_id', $product_skus)->where('attribute_id', '!=', 1)->get()->pluck('attribute_id');
        $attribute_value_ids = ProductVariations::whereIn('product_sku_id', $product_skus)->where('attribute_id', '!=', 1)->get()->pluck('attribute_value_id');
        $attribute_list = Attribute::with('values')->whereIn('id', $attribute_ids)->get();
        return $attribute_list;
    }
}
