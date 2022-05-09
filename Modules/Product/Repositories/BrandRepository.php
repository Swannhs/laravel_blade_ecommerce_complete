<?php

namespace Modules\Product\Repositories;

use Modules\Product\Entities\Brand;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Product\Imports\BrandImport;
use Modules\Product\Export\BrandExport;

class BrandRepository
{
    public function getAll()
    {
        return Brand::latest()->get();
    }

    public function getActiveAll(){
        return Brand::where('status', 1)->latest()->get();
    }

    public function getBySearch($data)
    {
        return Brand::where('name','LIKE','%'.$data.'%')->get();
    }

    public function getByPaginate($count)
    {
        return Brand::take($count)->orderBy('sort_id', 'asc')->get();
    }

    public function getBySkipTake($skip, $take)
    {
        return Brand::skip($skip)->take($take)->orderBy('sort_id', 'asc')->get();
    }

    public function getbrandbySort()
    {
        return Brand::orderBy("sort_id","asc")->get();
    }

    public function create(array $data)
    {
        $variant = new Brand();
        $variant->fill($data)->save();
    }

    public function find($id)
    {
        return Brand::find($id);
    }

    public function update(array $data, $id)
    {

        $variant = Brand::findOrFail($id);
        $variant->update($data);
    }

    public function delete($id)
    {
        $brand = Brand::findOrFail($id);
        
        if (count($brand->products) > 0 || count($brand->MenuElements) > 0 || count($brand->MenuBottomPanel) > 0 || count($brand->Silders) > 0 ||
         count($brand->homepageCustomBrands) > 0) {
            return "not_possible";
        }
        $brand->delete();
        return 'possible';

    }

    public function getBrandForSpecificCategory($category_id, $category_ids)
    {
        $brand_list = Brand::whereHas('products', function($q) use($category_id, $category_ids){
            $q->whereIn('category_id',$category_ids)->orWhere('category_id',$category_id);
        })->get();
        return $brand_list;
    }

    public function findBySlug($slug)
    {
        return Brand::where('slug', $slug)->first();
    }

    public function csvUploadBrand($data)
    {
        Excel::import(new BrandImport, $data['file']->store('temp'));
    }

    public function csvDownloadBrand()
    {
        if (file_exists(storage_path("app/brand_list.xlsx"))) {
          unlink(storage_path("app/brand_list.xlsx"));
        }
        return Excel::store(new BrandExport, 'brand_list.xlsx');
    }
}
