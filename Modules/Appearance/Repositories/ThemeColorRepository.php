<?php

namespace Modules\Appearance\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Appearance\Entities\ThemeColor;

class ThemeColorRepository
{

    public function update($request, $id)
    {
        if($id  != 1){
            $themeColor = ThemeColor::findOrFail($id);
            $request['toastr_time'] = $request['toastr_time']*1000;
            $themeColor->update($request->all());
        }
    }



    public function getSingle($id)
    {
        return ThemeColor::findOrFail($id);
    }



    public function activeColor()
    {
        return ThemeColor::where('status',1)->first();
    }



    public function activate($id)
    {
        DB::transaction(function () use ($id) {
            $activeColor = $this->activeColor();
            $activeColor->status = 0;
            $activeColor->save();
            $themeColor = $this->getSingle($id);
            $themeColor->status = 1;
            $themeColor->save();
        });
    }



    public function getAll()
    {
        return ThemeColor::all();
    }




}
