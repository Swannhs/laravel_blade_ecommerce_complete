<?php

namespace Modules\Appearance\Services;

use \Modules\Appearance\Repositories\ColorRepository;

class ColorService{

    protected $colorRepository;


    public function __construct(ColorRepository  $colorRepository)
    {
        $this->colorRepository = $colorRepository;
    }


    public function all()
    {
        return $this->colorRepository->all();
    }


    public function store($request)
    {
        return $this->colorRepository->store($request);
    }


    public function update($request,$id)
    {
        return $this->colorRepository->update($request,$id);
    }


    public function destroy($id)
    {
        return $this->colorRepository->destroy($id);
    }


    public function getSingle($id)
    {
        return $this->colorRepository->getSingle($id);
    }


    public function activate($id)
    {
        return $this->colorRepository->activate($id);
    }

    
    public function clone($id)
    {
        return $this->colorRepository->clone($id);
    }


}
