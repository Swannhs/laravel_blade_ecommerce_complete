<?php
namespace Modules\Appearance\Repositories;

use Modules\Appearance\Entities\Header;
use Modules\Appearance\Entities\HeaderCategoryPanel;
use Modules\Appearance\Entities\HeaderNewUserZonePanel;
use Modules\Appearance\Entities\HeaderProductPanel;
use Modules\Appearance\Entities\HeaderSliderPanel;
use Modules\Marketing\Entities\NewUserZone;
use Modules\Product\Entities\Category;
use Modules\Seller\Entities\SellerProduct;
use App\Traits\ImageStore;
use Modules\Product\Entities\Brand;
use Modules\Setup\Entities\Tag;

class HeaderRepository {
    use ImageStore;

    public function getAllCategory(){
        return Category::latest()->get();
    }
    public function getAllProduct(){
        return SellerProduct::with('product','seller.role')->where('status', 1)->activeSeller()->latest()->get();
    }
    public function getAllZones(){
        return NewUserZone::where('status',1)->latest()->get();
    }

    public function getAllBrand(){
        return Brand::where('status', 1)->latest()->get();
    }

    public function getAllTag(){
        return Tag::latest()->get();
    }

    public function getHeaders(){
        return Header::all();
    }
    public function getById($id){
        return Header::findOrFail($id);
    }
    public function update($data){

        Header::where('id',$data['id'])->first()->update([
            'column_size' => $data['column_size'],
            'is_enable' => isset($data['is_enable'])?$data['is_enable']:0
        ]);
        return true;
    }
    public function addElement($data){
        $header = Header::findOrFail($data['id']);

        if($header->type == 'category'){
            foreach($data['category'] as $key => $id){
                $category = Category::findOrFail($id);
                HeaderCategoryPanel::create([
                    'title' => $category->name,
                    'category_id' => $id,
                    'status' => 1,
                    'is_newtab' => 0
                ]);
            }
            return true;
        }
        elseif($header->type == 'product'){
            foreach($data['product'] as $key => $id){
                $product = SellerProduct::findOrFail($id);
                HeaderProductPanel::create([
                    'title' => $product->product->product_name,
                    'product_id' => $id,
                    'status' => 1,
                    'is_newtab' => 0
                ]);
            }
            return true;
        }elseif($header->type == 'slider'){
            if(isset($data['slider_image'])){
                $imagename = ImageStore::saveImage($data['slider_image'],365,660);
                $data['slider_image'] = $imagename;
            }

            HeaderSliderPanel::create([
                'name' => $data['name'],
                'url' => (isset($data['data_type']) && $data['data_type'] == 'url' && isset($data['data_id']))?$data['data_id']:null,
                'data_type' => isset($data['data_type'])?$data['data_type']:null,
                'data_id' => (isset($data['data_type']) && $data['data_type'] != 'url' && isset($data['data_id']))?$data['data_id']:null,
                'slider_image' => isset($data['slider_image'])?$data['slider_image']:null,
                'status' => $data['status'],
                'is_newtab' => isset($data['is_newtab'])?$data['is_newtab']:0
            ]);

            return true;
        }

        else{
            return false;
        }

    }

    public function updateElement($data){
        $header = Header::findOrFail($data['header_id']);
        if($header->type == 'category'){
            HeaderCategoryPanel::where('id',$data['id'])->first()->update([
                'title' => $data['title'],
                'category_id' => $data['category'],
                'is_newtab' => isset($data['is_newtab'])?$data['is_newtab']:0
            ]);
            return true;
        }
        elseif($header->type == 'product'){
            HeaderProductPanel::where('id',$data['id'])->first()->update([
                'title' => $data['title'],
                'product_id' => $data['product'],
                'is_newtab' => isset($data['is_newtab'])?$data['is_newtab']:0
            ]);
            return true;
        }
        elseif($header->type == 'new_user_zone'){
            HeaderNewUserZonePanel::first()->update([
                'navigation_label' => $data['navigation_label'],
                'title' => $data['title'],
                'pricing' => $data['pricing'],
                'new_user_zone_id' => $data['new_user_zone_id'],
            ]);
            return true;
        }
        elseif($header->type == 'slider'){
            $slider = HeaderSliderPanel::findOrFail($data['id']);

            if(isset($data['slider_image'])){
                ImageStore::deleteImage($slider->slider_image);
                $imagename = ImageStore::saveImage($data['slider_image'],365,660);
                $data['slider_image'] = $imagename;
            }else{
                $data['slider_image'] =$slider->slider_image;
            }
            $slider->update([

                'name' => $data['name'],
                'url' => (isset($data['data_type']) && $data['data_type'] == 'url' && isset($data['data_id']))?$data['data_id']:null,
                'data_type' => isset($data['data_type'])?$data['data_type']:null,
                'data_id' => (isset($data['data_type']) && $data['data_type'] != 'url' && isset($data['data_id']))?$data['data_id']:null,
                'slider_image' => $data['slider_image'],
                'status' => $data['status'],
                'is_newtab' => isset($data['is_newtab'])?$data['is_newtab']:0

            ]);
            return true;
        }
        else{
            return false;
        }
    }

    public function deleteElement($data){
        $header = Header::findOrFail($data['header_id']);
        if($header->type == 'category'){
            HeaderCategoryPanel::where('id',$data['id'])->first()->delete();
            return true;
        }
        elseif($header->type == 'product'){
            HeaderProductPanel::where('id',$data['id'])->first()->delete();
            return true;
        }
        elseif($header->type == 'slider'){
            $slider = HeaderSliderPanel::findOrFail($data['id']);
            ImageStore::deleteImage($slider->slider_image);
            $slider->delete();
            return true;
        }
        else{
            return false;
        }
    }

    public function sortElement($data){
        $header = Header::findOrFail($data['header_id']);
        if($header->type == 'category'){
            foreach($data['ids'] as $key => $id){
                HeaderCategoryPanel::where('id',$id)->first()->update([
                    'position' => $key + 1
                ]);
            }
            return true;
        }
        elseif($header->type == 'product'){
            foreach($data['ids'] as $key => $id){
                HeaderProductPanel::where('id',$id)->first()->update([
                    'position' => $key + 1
                ]);
            }
            return true;
        }
        elseif($header->type == 'slider'){

            foreach($data['ids'] as $key => $id){
                HeaderSliderPanel::where('id',$id)->first()->update([
                    'position' => $key + 1
                ]);
            }
            return true;
        }

        else{
            return false;
        }
    }

    public function getSliders(){
        return HeaderSliderPanel::where('status', 1)->latest()->get();
    }

    public function getSingleSlider($id){
        return HeaderSliderPanel::where('status', 1)->where('id', $id)->firstOrFail();
    }

    public function updateEnableStatus($data)
    {
        return Header::where('id',$data['id'])->first()->update([
            'is_enable' => isset($data['status']) ? $data['status'] : 0
        ]);
    }
}
