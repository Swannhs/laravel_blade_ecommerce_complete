<?php

namespace Modules\Menu\Services;

use \Modules\Menu\Repositories\MenuRepository;
use phpDocumentor\Reflection\Types\This;

class MenuService{
    
    protected $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function getAll(){
        return $this->menuRepository->getAll();
    }
    public function getMenus(){
        return $this->menuRepository->getMenus();
    }
    public function getCategories(){
        return $this->menuRepository->getCategories();
    }
    public function getProducts(){
        return $this->menuRepository->getProducts();
    }
    public function getBrands(){
        return $this->menuRepository->getBrands();
    }
    public function getPages(){
        return $this->menuRepository->getPages();
    }
    public function getTags(){
        return $this->menuRepository->getTags();
    }
    public function store($data){

        return $this->menuRepository->store($data);
    }
    public function update($data){
        return $this->menuRepository->update($data);
    }
    public function addColumn($data){
        return $this->menuRepository->addColumn($data);
    }
    public function addElement($data){
        return $this->menuRepository->addElement($data);
    }

    public function addRightPanelData($data){
        return $this->menuRepository->addRightPanelData($data);
    }

    public function addBottomPanelData($data){
        return $this->menuRepository->addBottomPanelData($data);
    }

    public function sort($data){
        return $this->menuRepository->sort($data);
    }

    public function sortElement($data){
        return $this->menuRepository->sortElement($data);
    }
    public function sortColumn($data){
        return $this->menuRepository->sortColumn($data);
    }
    public function sortMenuForMultiMenu($data){
        return $this->menuRepository->sortMenuForMultiMenu($data);
    }
    public function sortRightPanelData($data){
        return $this->menuRepository->sortRightPanelData($data);
    }
    public function sortBottomPanelData($data){
        return $this->menuRepository->sortBottomPanelData($data);
    }

    public function addToColumn($data){
        return $this->menuRepository->addToColumn($data);
    }
    public function removeFromColumn($data){
        return $this->menuRepository->removeFromColumn($data);
    }
    public function addMenu($data){
        return $this->menuRepository->addMenu($data);
    }

    public function getById($id){
        return $this->menuRepository->getById($id);
    }
    public function columnUpdate($data){
        return $this->menuRepository->columnUpdate($data);
    }
    public function deleteById($id){
        return $this->menuRepository->deleteById($id);
    }
    public function deleteColumn($id){
        return $this->menuRepository->deleteColumn($id);
    }
    public function deleteElement($id){
        return $this->menuRepository->deleteElement($id);
    }
    public function deleteMenuForMultiMenu($data){
        return $this->menuRepository->deleteMenuForMultiMenu($data);
    }
    public function deleteRightPanelData($id){
        return $this->menuRepository->deleteRightPanelData($id);
    }
    public function deleteBottomPanelData($id){
        return $this->menuRepository->deleteBottomPanelData($id);
    }
    public function editElementById($id){
        return $this->menuRepository->editElementById($id);
    }
    public function elementUpdate($data){
        return $this->menuRepository->elementUpdate($data);
    }
    public function updateMenuForMultiMenu($data){
        return $this->menuRepository->updateMenuForMultiMenu($data);
    }
    public function updateRightPanelData($data){
        return $this->menuRepository->updateRightPanelData($data);
    }
    public function updateBottomPanelData($data){
        return $this->menuRepository->updateBottomPanelData($data);
    }

    public function statusChange($data){
        return $this->menuRepository->statusChange($data);
    }
}
