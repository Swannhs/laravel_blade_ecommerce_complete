<?php

namespace Modules\Appearance\Services;

use \Modules\Appearance\Repositories\ThemeColorRepository;

class ThemeColorService{

    protected $themeColorRepository;


    public function __construct(ThemeColorRepository  $themeColorRepository)
    {
        $this->themeColorRepository = $themeColorRepository;
    }



    public function update($request,$id)
    {
        return $this->themeColorRepository->update($request,$id);
    }



    public function getSingle($id)
    {
        return $this->themeColorRepository->getSingle($id);
    }




    public function activate($id)
    {
        return $this->themeColorRepository->activate($id);
    }



    public function activeColor()
    {
        return $this->themeColorRepository->activeColor();
    }


    public function getAll()
    {
        return $this->themeColorRepository->getAll();
    }


}
