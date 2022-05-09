<?php
namespace Modules\Menu\Repositories;

use Illuminate\Support\Facades\Cache;
use Modules\FrontendCMS\Entities\DynamicPage;
use Modules\Menu\Entities\MegaMenuBottomPanel;
use Modules\Menu\Entities\MegaMenuRightPanel;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Entities\MenuColumn;
use Modules\Menu\Entities\MenuElement;
use Modules\Menu\Entities\MultiMegaMenu;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;
use Modules\Seller\Entities\SellerProduct;
use Modules\Setup\Entities\Tag;

class MenuRepository {

    public function getALl(){
        return Menu::with('elements')->orderBy('order_by')->get();
    }
    public function getById($id){
        return Menu::findOrFail($id);
    }
    public function getMenus(){
        return Menu::where('menu_type','!=','multi_mega_menu')->latest()->get();
    }
    public function getCategories(){
        return Category::with('subCategories')->get();
    }
    public function getProducts(){
        return SellerProduct::with('product')->activeSeller()->get();
    }
    public function getBrands(){
        return Brand::where('status', 1)->get();
    }
    public function getPages(){
        if(isModuleActive('MultiVendor')){
            $pages = DynamicPage::where('status',1)->get();
        }else{
            $pages = DynamicPage::where('status',1)->where('id', '!=', 4)->get();
        }

        if(!isModuleActive('Affiliate')){
            $pages =  $pages->filter(function($item) {
                if($item->module != 'Affiliate'){
                    return $item->id;
                }
            });
        }

        if(!isModuleActive('Lead')){
            $pages =  $pages->filter(function($item) {
                if($item->module != 'Lead'){
                    return $item->id;
                }
            });
        }

        return $pages;
    }
    public function getTags(){
        return Tag::latest()->get();
    }

    public function store($data){
        $menu = Menu::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'icon' => $data['icon'],
            'menu_type' => $data['menu_type'],
            'menu_position' => $data['menu_position'],
            'status' => $data['status']
        ]);
        if($data['menu_type'] == 'mega_menu'){
            MenuColumn::create([
                'column' => 'Column 1',
                'size' => '1/3',
                'menu_id' => $menu->id
            ]);
        }
        return true;
    }
    public function update($data){
        $menu = Menu::findOrFail($data['id']);
        $menu->update([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'icon' => $data['icon'],
            'status' => $data['status'],
            'menu_position' => $data['menu_position'],
        ]);
        return true;
    }

    public function addColumn($data){
        return MenuColumn::create([
            'column' => $data['column'],
            'size' => $data['size'],
            'menu_id' => $data['id'],
            'position' => 987678
        ]);
    }
    public function addElement($data){
        if($data['type'] == 'category'){
            $category = Category::findOrFail($data['element_id']);
            return MenuElement::create([
                'title' => $category->name,
                'menu_id' => $data['menu_id'],
                'type' => $data['type'],
                'element_id' => $data['element_id'],
                'position' => 387437
            ]);
        }elseif($data['type'] == 'link'){
            return MenuElement::create([
                'menu_id' => $data['menu_id'],
                'type' => $data['type'],
                'link' => $data['link'],
                'title' => $data['title'],
                'position' => 387437
            ]);
        }elseif($data['type'] == 'page'){
            $page = DynamicPage::findOrFail($data['element_id']);
            return MenuElement::create([
                'title' => $page->title,
                'menu_id' => $data['menu_id'],
                'type' => $data['type'],
                'element_id' => $data['element_id'],
                'position' => 387437
            ]);
        }
        elseif($data['type'] == 'product'){
            $product = SellerProduct::findOrFail($data['element_id']);
            return MenuElement::create([
                'title' => $product->product->product_name,
                'menu_id' => $data['menu_id'],
                'type' => $data['type'],
                'element_id' => $data['element_id'],
                'position' => 387437
            ]);
        }
        elseif($data['type'] == 'brand'){
            $brand = Brand::findOrFail($data['element_id']);
            return MenuElement::create([
                'title' => $brand->name,
                'menu_id' => $data['menu_id'],
                'type' => $data['type'],
                'element_id' => $data['element_id'],
                'position' => 387437
            ]);
        }
        elseif($data['type'] == 'tag'){
            $tag = Tag::findOrFail($data['element_id']);
            return MenuElement::create([
                'title' => $tag->name,
                'menu_id' => $data['menu_id'],
                'type' => $data['type'],
                'element_id' => $data['element_id'],
                'position' => 387437
            ]);
        }else{
            return false;
        }
        return false;

    }

    public function addMenu($data){
        $menu = Menu::findOrFail($data['menu_id']);
        MultiMegaMenu::create([
            'title' => $menu->name,
            'multi_mega_menu_id' => $data['multi_mega_menu_id'],
            'menu_id' => $data['menu_id']
        ]);
        $menu->update([
            'has_parent' => 1
        ]);
        return true;
    }

    public function addRightPanelData($data){
        $category = Category::findOrFail($data['category_id']);
        return MegaMenuRightPanel::create([
            'title' => $category->name,
            'menu_id' => $data['menu_id'],
            'category_id' => $data['category_id']
        ]);
    }
    public function addBottomPanelData($data){
        $brand = Brand::findOrFail($data['brand_id']);
        return MegaMenuBottomPanel::create([
            'title' => $brand->name,
            'menu_id' => $data['menu_id'],
            'brand_id' => $data['brand_id']
        ]);
    }


    public function sort($data){
        foreach($data['ids'] as $key => $id){
            $menu = Menu::find($id);
            $menu->update([
                'order_by' => $key + 1
            ]);
        }
        return true;
    }

    public function sortElement($data){
        foreach($data['ids'] as $key => $id){
            $element = MenuElement::find($id);
            $element->update([
                'position' => $key + 1
            ]);
        }
        return true;
    }
    public function sortColumn($data){
        foreach($data['ids'] as $key => $id){
            $element = MenuColumn::find($id);
            $element->update([
                'position' => $key + 1
            ]);
        }
        return true;
    }

    public function sortRightPanelData($data){
        foreach($data['ids'] as $key => $id){
            $item = MegaMenuRightPanel::find($id);
            $item->update([
                'position' => $key + 1
            ]);
        }
        return true;
    }

    public function sortBottomPanelData($data){
        foreach($data['ids'] as $key => $id){
            $item = MegaMenuBottomPanel::find($id);
            $item->update([
                'position' => $key + 1
            ]);
        }
        return true;
    }

    public function sortMenuForMultiMenu($data){
        foreach($data['ids'] as $key => $id){
            $menu = MultiMegaMenu::find($id);
            $menu->update([
                'position' => $key + 1
            ]);
        }
        return true;
    }

    public function addToColumn($data){
        $element = MenuElement::find($data['element']);
        return $element->update([
            'column_id' => $data['column_id']
        ]);
    }

    public function removeFromColumn($data){
        $element = MenuElement::find($data['element']);
        return $element->update([
            'column_id' => null
        ]);
    }

    public function columnUpdate($data){
        return MenuColumn::findOrFail($data['column_id'])->update([
            'column' => $data['column'],
            'size' => $data['size']
        ]);
    }

    public function deleteById($id){
        $menu = Menu::where('id', $id)->first();
        Cache::forget('MegaMenu');
        $used_in_multi_mega_menu = MultiMegaMenu::where('menu_id', $id)->first();

        if($used_in_multi_mega_menu){
            return 'not_possible';
        }else{
            if(count($menu->menus) > 0){
                $menus = $menu->menus->pluck('id');
                MultiMegaMenu::destroy($menus);
            }
            if(count($menu->allElements) > 0){
                $elements = $menu->allElements->pluck('id');
                MenuElement::destroy($elements);
            }
            if(count($menu->columns) > 0){
                $columns = $menu->columns->pluck('id');
                MenuColumn::destroy($columns);
            }
            $menu->delete();
            return 'possible';
        }
    }

    public function deleteColumn($id){
        $column = MenuColumn::find($id);
        $element = MenuElement::where('column_id',$id)->pluck('id');
        MenuElement::destroy($element);
        $column->delete();
        return true;
    }

    public function deleteElement($id){
        $element = MenuElement::find($id);
        if(count($element->childs) > 0){
            foreach($element->childs as $child){
                $child->update([
                    'parent_id' => $element->parent_id
                ]);
            }
        }
        $element->delete();
        return true;
    }

    public function deleteMenuForMultiMenu($data){
        $menu = MultiMegaMenu::where('multi_mega_menu_id',$data['menu_id'])->where('id',$data['id'])->firstOrFail();
        $menu->delete();
        return true;
    }

    public function deleteRightPanelData($id){
        MegaMenuRightPanel::find($id)->delete();
        return true;
    }

    public function deleteBottomPanelData($id){
        MegaMenuBottomPanel::find($id)->delete();
        return true;
    }

    public function editElementById($id){
        return MenuElement::findOrFail($id);
    }
    public function elementUpdate($data){
        if($data['type'] == 'category'){
            MenuElement::where('id',$data['id'])->first()->update([
                'menu_id' => $data['menu_id'],
                'type' => $data['type'],
                'element_id' => $data['category'],
                'title' => $data['title'],
                'show' => isset($data['show'])?$data['show']:0,
                'is_newtab' => isset($data['is_newtab'])?$data['is_newtab']:0
            ]);
        }elseif($data['type'] == 'link'){
            return MenuElement::where('id',$data['id'])->first()->update([
                'menu_id' => $data['menu_id'],
                'type' => $data['type'],
                'link' => $data['link'],
                'title' => $data['title'],
                'show' => isset($data['show'])?$data['show']:0,
                'is_newtab' => isset($data['is_newtab'])?$data['is_newtab']:0
            ]);
        }elseif($data['type'] == 'page'){
            return MenuElement::where('id',$data['id'])->first()->update([
                'menu_id' => $data['menu_id'],
                'type' => $data['type'],
                'element_id' => $data['page'],
                'title' => $data['title'],
                'show' => isset($data['show'])?$data['show']:0,
                'is_newtab' => isset($data['is_newtab'])?$data['is_newtab']:0
            ]);
        }
        elseif($data['type'] == 'product'){
            return MenuElement::where('id',$data['id'])->first()->update([
                'menu_id' => $data['menu_id'],
                'type' => $data['type'],
                'element_id' => $data['product'],
                'title' => $data['title'],
                'show' => isset($data['show'])?$data['show']:0,
                'is_newtab' => isset($data['is_newtab'])?$data['is_newtab']:0
            ]);
        }
        elseif($data['type'] == 'brand'){
            return MenuElement::where('id',$data['id'])->first()->update([
                'menu_id' => $data['menu_id'],
                'type' => $data['type'],
                'element_id' => $data['brand'],
                'title' => $data['title'],
                'show' => isset($data['show'])?$data['show']:0,
                'is_newtab' => isset($data['is_newtab'])?$data['is_newtab']:0
            ]);
        }
        elseif($data['type'] == 'tag'){
            $tag = Tag::find($data['tag']);
            return MenuElement::where('id',$data['id'])->first()->update([
                'menu_id' => $data['menu_id'],
                'type' => $data['type'],
                'element_id' => $data['tag'],
                'title' => $tag->name,
                'show' => isset($data['show'])?$data['show']:0,
                'is_newtab' => isset($data['is_newtab'])?$data['is_newtab']:0
            ]);
        }else{
            return false;
        }
        return false;
    }
    public function updateMenuForMultiMenu($data){
        $menu = MultiMegaMenu::findOrFail($data['id']);
        $menu->update([
            'title' => $data['title'],
            'is_newtab' => isset($data['is_newtab'])?$data['is_newtab']:0,
            'menu_id' => $data['menu']
        ]);
        Menu::where('id',$data['menu'])->first()->update([
            'has_parent' => 1
        ]);

        return true;
    }


    public function updateRightPanelData($data){
        $item = MegaMenuRightPanel::findOrFail($data['id']);
        $item->update([
            'title' => $data['title'],
            'category_id' => $data['category'],
            'is_newtab' => isset($data['is_newtab'])?$data['is_newtab']:0
        ]);
    }

    public function updateBottomPanelData($data){
        $item = MegaMenuBottomPanel::findOrFail($data['id']);
        $item->update([
            'title' => $data['title'],
            'brand_id' => $data['brand'],
            'is_newtab' => isset($data['is_newtab'])?$data['is_newtab']:0
        ]);
    }

    public function statusChange($data){
        $menu = Menu::findOrFail($data['id']);
        $menu->update([
            'status' => $data['status']
        ]);
        return true;
    }

}
