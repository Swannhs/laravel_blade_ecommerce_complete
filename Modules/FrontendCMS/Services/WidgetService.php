<?php

namespace Modules\FrontendCMS\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\FrontendCMS\Repositories\WidgetRepository;

class WidgetService{

    protected $widgetRepository;

    public function __construct(WidgetRepository  $widgetRepository)
    {
        $this->widgetRepository = $widgetRepository;
    }
    public function getAll(){
        return $this->widgetRepository->getAll();
    }

    public function getBySectionName($data){
        return $this->widgetRepository->getBySectionName($data);
    }
    public function getProducts(){
        return $this->widgetRepository->getProducts();
    }
    public function getCategories(){
        return $this->widgetRepository->getCategories();
    }
    public function getBrands(){
        return $this->widgetRepository->getBrands();
    }

    public function update($data){
        return $this->widgetRepository->update($data);
    }
    
}
