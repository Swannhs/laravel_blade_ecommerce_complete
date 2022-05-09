<?php

namespace Modules\Menu\Http\Controllers;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Menu\Entities\MenuElement;
use Modules\Menu\Http\Requests\CreateMenuRequest;
use Modules\Menu\Services\MenuService;
use phpDocumentor\Reflection\Types\This;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Menu\Entities\MenuColumn;
use Modules\Menu\Http\Requests\UpdateMenuRequest;
use Modules\UserActivityLog\Traits\LogActivity;

class MenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->middleware('maintenance_mode');
        $this->menuService = $menuService;
    }

    public function index()
    {
        try{
            $menus = $this->menuService->getAll();
            return view('menu::menu.index',compact('menus'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }


    public function store(CreateMenuRequest $request)
    {
        try{
            $this->menuService->store($request->except('_token'));

            LogActivity::successLog('Menu added.');
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
        return $this->reloadWithData();
    }

    public function setup($id){

        try{
            $data['menu'] = $this->menuService->getById($id);
            $data['categories'] = $this->menuService->getCategories()->where('parent_id',0);
            $data['products'] = $this->menuService->getProducts();
            $data['brands'] = $this->menuService->getBrands();
            $data['pages'] = $this->menuService->getPages();
            $data['tags'] = $this->menuService->getTags();
            $data['menus'] = $this->menuService->getMenus();
            return view('menu::menu.components.setup',$data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

    public function addColumn(Request $request){

        try{
            $menuColumn = MenuColumn::where('menu_id',$request->id)->get();
            if(count($menuColumn) < 6){
                $this->menuService->addColumn($request->except('_token'));
                $data['menu'] = $this->menuService->getById($request->id);
                $data['categories'] = $this->menuService->getCategories();
                $data['products'] = $this->menuService->getProducts();
                $data['brands'] = $this->menuService->getBrands();
                $data['pages'] = $this->menuService->getPages();
                $data['tags'] = $this->menuService->getTags();
                $data['menus'] = $this->menuService->getMenus();
                LogActivity::successLog('column created successful.');
                return view('menu::menu.components.element_list',$data);
            }else{
                return response()->json([
                    'limit_cross' => 'You already create maximum number of column.'
                ]);
            }

        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

    public function addElement(Request $request){
        try{
            if($request->type != 'link'){
                foreach($request->element_id as $element_id){
                    $requestData = [
                        'menu_id' => $request->menu_id,
                        'type' => $request->type,
                        'element_id' => $element_id
                    ];

                    $this->menuService->addElement($requestData);

                }
            }else{
                $this->menuService->addElement($request->except('_token'));
            }
            $data['menu'] = $this->menuService->getById($request->menu_id);
            $data['categories'] = $this->menuService->getCategories();
            $data['products'] = $this->menuService->getProducts();
            $data['brands'] = $this->menuService->getBrands();
            $data['pages'] = $this->menuService->getPages();
            $data['tags'] = $this->menuService->getTags();
            $data['menus'] = $this->menuService->getMenus();
            LogActivity::successLog('element added successful.');
            return view('menu::menu.components.element_list',$data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

    public function addMenu(Request $request){
        try{
            if(count($request->menus)>0){
                foreach($request->menus as $menu_id){
                    $requestData = [
                        'multi_mega_menu_id' => $request->menu_id,
                        'menu_id' => $menu_id
                    ];
                    $this->menuService->addMenu($requestData);
                }
            }
            $data['menu'] = $this->menuService->getById($request->menu_id);
            $data['categories'] = $this->menuService->getCategories();
            $data['products'] = $this->menuService->getProducts();
            $data['brands'] = $this->menuService->getBrands();
            $data['pages'] = $this->menuService->getPages();
            $data['tags'] = $this->menuService->getTags();
            $data['menus'] = $this->menuService->getMenus();


            LogActivity::successLog('Menu added.');
            return view('menu::menu.components.element_list',$data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

    public function addRightPanelData(Request $request){
        try{
            if(count($request->categories) > 0){
                foreach($request->categories as $key => $id){
                    $requestData = [
                        'menu_id' => $request->menu_id,
                        'category_id' => $id
                    ];
                    $this->menuService->addRightPanelData($requestData);
                }
            }
            $data['menu'] = $this->menuService->getById($request->menu_id);
            $data['categories'] = $this->menuService->getCategories();

            LogActivity::successLog('Right panel data added.');
            return view('menu::menu.components.rightpanel_category_list', $data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }

    }

    public function addBottomPanelData(Request $request){
        try{
            if(count($request->brands) > 0){
                foreach($request->brands as $key => $id){
                    $requestData = [
                        'menu_id' => $request->menu_id,
                        'brand_id' => $id
                    ];
                    $this->menuService->addBottomPanelData($requestData);
                }
            }
            $data['menu'] = $this->menuService->getById($request->menu_id);
            $data['brands'] = $this->menuService->getBrands();
            LogActivity::successLog('Bottom panel data added.');
            return view('menu::menu.components.bottompanel_brand_list', $data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

    public function edit(){
        try{
            $item = $this->menuService->getById(decrypt($_GET['id']));
            return view('menu::menu.components.edit',compact('item'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

    public function update(UpdateMenuRequest $request){
        try{
            $this->menuService->update($request->except('_token'));

            LogActivity::successLog('Menu updated.');
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
        return $this->reloadWithData();
    }

    public function sort(Request $request){
        try{
            $this->menuService->sort($request->except('_token'));
            LogActivity::successLog('Menu sorted.');
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }

        return $this->reloadWithData();

    }

    public function sortColumn(Request $request){

        try{
            $sort = $this->menuService->sortColumn($request->except('_token'));

            LogActivity::successLog('column sorted successful.');
            return $sort;
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

    public function sortElement(Request $request){
        try{
            $sort = $this->menuService->sortElement($request->except('_token'));
            LogActivity::successLog('Element sorted successful.');
            return $sort;
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

    public function sortMenuForMultiMenu(Request $request){
        try{
            $sort = $this->menuService->sortMenuForMultiMenu($request->except('_token'));
            LogActivity::successLog('Sort menu for multi menu successful.');
            return $sort;
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }

    }

    public function sortRightPanelData(Request $request){
        try{
            $sort = $this->menuService->sortRightPanelData($request->except('_token'));
            LogActivity::successLog('Sort right panel data successful.');
            return $sort;
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

    public function sortBottomPanelData(Request $request){
        try{
            $sort = $this->menuService->sortBottomPanelData($request->except('_token'));
            LogActivity::successLog('Sort bottom panel data successful.');
            return $sort;
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

    public function addToColumn(Request $request){
        try{
            $add = $this->menuService->addToColumn($request->except('_token'));
            LogActivity::successLog('add to column successful.');
            return $add;
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }
    public function removeFromColumn(Request $request){
        try{
            $remove = $this->menuService->removeFromColumn($request->except('_token'));
             LogActivity::successLog('remove from column successful.');
            return $remove;
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

    public function columnDelete(Request $request){
        try{
            $this->menuService->deleteColumn($request->id);
            $data['menu'] = $this->menuService->getById($request->menu_id);
            $data['categories'] = $this->menuService->getCategories();
            $data['products'] = $this->menuService->getProducts();
            $data['brands'] = $this->menuService->getBrands();
            $data['pages'] = $this->menuService->getPages();
            $data['tags'] = $this->menuService->getTags();
            $data['menus'] = $this->menuService->getMenus();
            LogActivity::successLog('column deleted');
            return view('menu::menu.components.element_list',$data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }
    public function elementDelete(Request $request){
        try{
            $this->menuService->deleteElement($request->id);
            $data['menu'] = $this->menuService->getById($request->menu_id);
            $data['categories'] = $this->menuService->getCategories();
            $data['products'] = $this->menuService->getProducts();
            $data['brands'] = $this->menuService->getBrands();
            $data['pages'] = $this->menuService->getPages();
            $data['tags'] = $this->menuService->getTags();
            $data['menus'] = $this->menuService->getMenus();
            LogActivity::successLog('Element deleted');
            return view('menu::menu.components.element_list',$data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

    public function deleteMenuForMultiMenu(Request $request){
        try{
            $this->menuService->deleteMenuForMultiMenu($request->except('_token'));
            $data['menu'] = $this->menuService->getById($request->menu_id);
            $data['categories'] = $this->menuService->getCategories();
            $data['products'] = $this->menuService->getProducts();
            $data['brands'] = $this->menuService->getBrands();
            $data['pages'] = $this->menuService->getPages();
            $data['tags'] = $this->menuService->getTags();
            $data['menus'] = $this->menuService->getMenus();
            LogActivity::successLog('Menu for multimenu deleted');
            return view('menu::menu.components.element_list',$data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }

    }

    public function deleteRightPanelData(Request $request){

        try{
            $this->menuService->deleteRightPanelData($request->id);

            $data['menu'] = $this->menuService->getById($request->menu_id);
            $data['categories'] = $this->menuService->getCategories();

            LogActivity::successLog('Right panel data deleted.');

            return view('menu::menu.components.rightpanel_category_list', $data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }

    }

    public function deleteBottomPanelData(Request $request){

        try{
            $this->menuService->deleteBottomPanelData($request->id);

            $data['menu'] = $this->menuService->getById($request->menu_id);
            $data['brands'] = $this->menuService->getBrands();

            LogActivity::successLog('Bottom panel data deleted.');
            return view('menu::menu.components.bottompanel_brand_list', $data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }

    }

    public function columnUpdate(Request $request){
        try{
            $this->menuService->columnUpdate($request->except('_token'));
            $data['menu'] = $this->menuService->getById($request->menu_id);
            $data['categories'] = $this->menuService->getCategories();
            $data['products'] = $this->menuService->getProducts();
            $data['brands'] = $this->menuService->getBrands();
            $data['pages'] = $this->menuService->getPages();
            $data['tags'] = $this->menuService->getTags();
            $data['menus'] = $this->menuService->getMenus();
            LogActivity::successLog('column updated.');
            return view('menu::menu.components.element_list',$data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }

    }

    public function elementUpdate(Request $request){
        try{
            $this->menuService->elementUpdate($request->except('_token'));
            $data['menu'] = $this->menuService->getById($request->menu_id);
            $data['categories'] = $this->menuService->getCategories();
            $data['products'] = $this->menuService->getProducts();
            $data['brands'] = $this->menuService->getBrands();
            $data['pages'] = $this->menuService->getPages();
            $data['tags'] = $this->menuService->getTags();
            $data['menus'] = $this->menuService->getMenus();
            LogActivity::successLog('element updated');
            return view('menu::menu.components.element_list',$data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

    public function updateMenuForMultiMenu(Request $request){
        try{
            $this->menuService->updateMenuForMultiMenu($request->except('_token'));
            $data['menu'] = $this->menuService->getById($request->menu_id);
            $data['categories'] = $this->menuService->getCategories();
            $data['products'] = $this->menuService->getProducts();
            $data['brands'] = $this->menuService->getBrands();
            $data['pages'] = $this->menuService->getPages();
            $data['tags'] = $this->menuService->getTags();
            $data['menus'] = $this->menuService->getMenus();
            LogActivity::successLog('update menu for multi menu');
            return view('menu::menu.components.element_list',$data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }

    public function updateRightPanelData(Request $request){
        try{
            $this->menuService->updateRightPanelData($request->except('_token'));

            $data['menu'] = $this->menuService->getById($request->menu_id);
            $data['categories'] = $this->menuService->getCategories();
            LogActivity::successLog('update right panel');

            return view('menu::menu.components.rightpanel_category_list', $data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }

    }

    public function updateBottomPanelData(Request $request){

        try{
            $this->menuService->updateBottomPanelData($request->except('_token'));

        $data['menu'] = $this->menuService->getById($request->menu_id);
        $data['brands'] = $this->menuService->getBrands();
        LogActivity::successLog('update bottom panel');

        return view('menu::menu.components.bottompanel_brand_list', $data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }


    public function NormalMenuOrder(Request $request){
        $menuItemOrder = json_decode($request->get('order'));
        $this->orderMenu($menuItemOrder, null);
        return true;

    }
    private function orderMenu(array $menuItems, $parentId){
        foreach($menuItems as $index => $item){
            $menuItem = MenuElement::findOrFail($item->id);
            $menuItem->update([
                'position' => $index + 1,
                'parent_id' => $parentId
            ]);

            if(isset($item->children)){
                $this->orderMenu($item->children, $menuItem->id);
            }
        }
    }

    public function status(Request $request){
        try{
            $this->menuService->statusChange($request->except('_token'));
            LogActivity::successLog('menu status changed.');
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
        return $this->reloadWithData();
    }

    public function destroy(Request $request)
    {
        try{
            $result = $this->menuService->deleteById($request->id);
            if($result == 'not_possible'){
                return 'not_posible';
            }else{
                return $this->reloadWithData();
            }
            LogActivity::successLog('menu deleted.');
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
        }

    }

    private function reloadWithData(){
        try{
            $menus = $this->menuService->getAll();
            return response()->json([
                'status' =>200,
                'TableData' =>  (string)view('menu::menu.components.list', compact('menus')),
                'CreateForm' =>  (string)view('menu::menu.components.create')
            ]);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }
}
