<?php
namespace Modules\FrontendCMS\Repositories;

use Modules\FrontendCMS\Entities\HomepageCustomBrand;
use Modules\FrontendCMS\Entities\HomepageCustomCategory;
use Modules\FrontendCMS\Entities\HomepageCustomProduct;
use Modules\FrontendCMS\Entities\HomePageSection;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;
use Modules\Seller\Entities\SellerProduct;

class WidgetRepository {

    public function getAll(){
        return HomePageSection::all();
    }

    public function getBySectionName($data){
        return HomePageSection::where('section_name',$data['value'])->first();
    }
    public function getProducts(){
        return SellerProduct::with('product')->where('status',1)->activeSeller()->get();
    }
    public function getCategories(){
        return Category::where('status',1)->get();
    }
    public function getBrands(){
        return Brand::where('status',1)->get();
    }

    public function update($data){

        HomePageSection::findOrFail($data['id'])->update([
            'title' => $data['title'],
            'column_size' => $data['column_size'],
            'status' => $data['status'],
            'type' => $data['type']
        ]);
        if($data['form_for'] == 'best_deals' || $data['form_for'] == 'top_picks' || $data['form_for'] == 'more_products'){

            $section = HomePageSection::where('id',$data['id'])->first();
            foreach($section->products as $product){
                foreach($data['product_list'] as $key => $item){
                    if($product->seller_product_id != $item){
                        $product->delete();
                    }
                }
            }

            foreach($data['product_list'] as $key => $item){

                HomepageCustomProduct::where('section_id',$data['id'])->updateOrCreate([
                    'section_id' => $data['id'],
                    'seller_product_id' => $data['product_list'][$key]
                ]);
            }
        }
        if($data['form_for'] == 'top_brands'){
            $section = HomePageSection::where('id',$data['id'])->first();
            foreach($section->brands as $brand){
                foreach($data['brand_list'] as $key => $item){
                    if($brand->brand_id != $item){
                        $brand->delete();
                    }
                }
            }

            foreach($data['brand_list'] as $key => $item){

                HomepageCustomBrand::where('section_id',$data['id'])->updateOrCreate([
                    'section_id' => $data['id'],
                    'brand_id' => $data['brand_list'][$key]
                ]);
            }
        }

        if($data['form_for'] == 'feature_categories'){
            $section = HomePageSection::where('id',$data['id'])->first();
            foreach($section->categories as $category){
                foreach($data['category_list'] as $key => $item){
                    if($category->category_id != $item){
                        $category->delete();
                    }
                }
            }


            foreach($data['category_list'] as $key => $item){

                HomepageCustomCategory::where('section_id',$data['id'])->updateOrCreate([
                    'section_id' => $data['id'],
                    'category_id' => $data['category_list'][$key]
                ]);
            }
        }


        return true;

    }

}
