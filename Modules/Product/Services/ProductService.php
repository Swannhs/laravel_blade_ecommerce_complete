<?php

namespace Modules\Product\Services;

use App\Traits\GenerateSlug;
use Illuminate\Support\Facades\Validator;
use \Modules\Product\Repositories\ProductRepository;
use App\Traits\ImageStore;
use Modules\Product\Entities\ProductSku;

class ProductService
{
    use ImageStore,GenerateSlug;
    protected $productRepository;

    public function __construct(ProductRepository  $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function all()
    {
        return $this->productRepository->getAll();
    }

    public function allbyPaginate()
    {
        return $this->productRepository->allbyPaginate();
    }

    public function getAllForEdit($id){
        return $this->productRepository->getAllForEdit($id);
    }

    public function getAllSKU(){
        return $this->productRepository->getAllSKU();
    }

    public function create($data)
    {
        $thumbnail_image = ImageStore::saveImage($data['thumbnail_image'], 250, 250);
        $data['thumbnail_image_source'] = $thumbnail_image;
        if (!empty($data['pdf_file'])) {
            $name = uniqid() . $data['pdf_file']->getClientOriginalName();
            $data['pdf_file']->move(public_path() . '/uploads/product_pdf/', $name);
            $data['pdf'] = '/uploads/product/' . $name;
        }
        if (!empty($data['galary_image'])) {
            $galary_image = [];
            foreach($data['galary_image'] as $image){
                $galary_image[] = ImageStore::saveImage($image,600,545);
            }
            $data['galary_image'] = $galary_image;

        }else{
            $data['galary_image'] = null;
        }
        if($data['is_physical'] == 0 && isset($data['digital_file'])) {
            if ($data['product_type'] == 2) {
                foreach ($data['digital_file'] as $key => $file) {
                    $name = uniqid() . $file->getClientOriginalName();
                    $file->move(public_path() . '/uploads/digital_file/', $name);
                    $data['file_source'][$key] = '/uploads/digital_file/' . $name;
                }
            }else {
                $name = uniqid() . $data['digital_file']->getClientOriginalName();
                $data['digital_file']->move(public_path() . '/uploads/digital_file/', $name);
                $data['file_source'] = '/uploads/digital_file/' . $name;
            }
        }
        if (!empty($data['meta_image'])) {
            $meta_image = ImageStore::saveImage($data['meta_image'],250,250);
            $data['meta_image'] = $meta_image;
        }
//        $data['slug'] = strtolower(str_replace(' ','-',$data['product_name']));
        $data['slug'] = $this->productSlug($data['product_name']);
        return $this->productRepository->create($data);
    }

    public function findById($id)
    {
        return $this->productRepository->find($id);
    }

    public function findProductSkuById($id)
    {
        return $this->productRepository->findProductSkuById($id);
    }

    public function update($data, $id)
    {
        $product = $this->findById($id);
        if (!empty($data['thumbnail_image'])) {
            ImageStore::deleteImage($product->thumbnail_image_source);
            $thumbnail_image = ImageStore::saveImage($data['thumbnail_image'],250,250);
            $data['thumbnail_image_source'] = $thumbnail_image;
        }

        if (!empty($data['pdf_file'])) {
            $name = uniqid() . $data['pdf_file']->getClientOriginalName();
            $data['pdf_file']->move(public_path() . '/uploads/product_pdf/', $name);
            $data['pdf'] = '/uploads/product/' . $name;
        }
        if (!empty($data['galary_image'])) {
            $images = $this->productRepository->getGalleryImage($id);
            foreach($images as $image){
                ImageStore::deleteImage($image->images_source);

            }
            $galary_image = [];
            foreach($data['galary_image'] as $image){
                $galary_image[] = ImageStore::saveImage($image,600,545);
            }
            $data['galary_image'] = $galary_image;

        }

        if (!empty($data['meta_image'])) {

            ImageStore::deleteImage($product->meta_image);
            $meta_image = ImageStore::saveImage($data['meta_image'],250,250);
            $data['meta_image'] = $meta_image;
        }
        $data['slug'] = $this->productSlug($data['product_name']);
        return $this->productRepository->update($data, $id);
    }

    public function deleteById($id)
    {
        return $this->productRepository->delete($id);
    }

    public function metaImgDeleteById($id){
        $product = $this->productRepository->find($id);
        ImageStore::deleteImage($product->meta_image);
        $product->update([
            'meta_image' => null
        ]);
        return true;
    }

    public function getRequestProduct(){
        return $this->productRepository->getRequestProduct();
    }
    public function productApproved($data){
        return $this->productRepository->productApproved($data);
    }

    public function updateRecentViewedConfig($data)
    {
        return $this->productRepository->updateRecentViewedConfig($data);
    }

    public function csvUploadCategory($data)
    {
        return $this->productRepository->csvUploadCategory($data);
    }
    public function getProduct()
    {
        return $this->productRepository->getProduct();
    }

    public function updateSkuByID($data){
        if(isset($data['variant_image'])){
            $sku = ProductSku::find($data['id']);
            ImageStore::deleteImage($sku->variant_image);
            $data['variant_image'] = ImageStore::saveImage($data['variant_image'],165,165);
        }
        return $this->productRepository->updateSkuByID($data);
    }

    public function getFilterdProduct($table){
        return $this->productRepository->getFilterdProduct($table);
    }
    public function getSellerProduct(){
        return $this->productRepository->getSellerProduct();
    }
}
