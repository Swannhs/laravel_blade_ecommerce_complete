<?php

namespace Modules\Appearance\Repositories;

use App\Traits\ImageStore;
use Illuminate\Support\Facades\DB;
use Modules\Appearance\Entities\AdminColor;

class ColorRepository
{

    use ImageStore;


    public function all()
    {
        return AdminColor::all();
    }



    public function store($request)
    {
        if ($request->color_mode == "gradient") {
            $request['solid_color'] = NULL;
        }
        if ($request->color_mode == "solid") {
            $request['gradient_color_one'] = NULL;
            $request['gradient_color_two'] = NULL;
            $request['gradient_color_three'] = NULL;
        }

        $request['toastr_time'] = $request['toastr_time']*1000;
        $color = AdminColor::create($request->all());

        if ($request->background_type == "image") {
            $file = $request->file('background_image');
            if ($request->hasFile('background_image')) {
                $filename = $this->saveImage($file, 1400, 1920);
            }
            $color->background_color = NULL;
            $color->background_image = $filename;
            $color->save();
        }
    }



    public function update($request, $id)
    {
        $adminColor = AdminColor::findOrFail($id);

        if ($request->color_mode == "gradient") {
            $request['solid_color'] = NULL;
        }
        if ($request->color_mode == "solid") {
            $request['gradient_color_one'] = NULL;
            $request['gradient_color_two'] = NULL;
            $request['gradient_color_three'] = NULL;
        }

        $adminColor->title = $request->title;
        $adminColor->color_mode = $request->color_mode;
        $adminColor->background_type = $request->background_type;
        $adminColor->base_color = $request->base_color;
        $adminColor->solid_color = $request->solid_color;
        $adminColor->gradient_color_one = $request->gradient_color_one;
        $adminColor->gradient_color_two = $request->gradient_color_two;
        $adminColor->gradient_color_three = $request->gradient_color_three;
        $adminColor->scroll_color = $request->scroll_color;
        $adminColor->text_color = $request->text_color;
        $adminColor->text_white = $request->text_white;
        $adminColor->background_white = $request->background_white;
        $adminColor->text_black = $request->text_black;
        $adminColor->background_black = $request->background_black;
        $adminColor->input_background = $request->input_background;
        $adminColor->border_color = $request->border_color;
        $adminColor->success_color = $request->success_color;
        $adminColor->warning_color = $request->warning_color;
        $adminColor->danger_color = $request->danger_color;
        $adminColor->toastr_position = $request->toastr_position;
        $adminColor->toastr_time = $request->toastr_time*1000;

        $adminColor->save();

        if($adminColor->is_active == 1){
            setEnv('toastr_time',$adminColor->toastr_time);
            setEnv('toastr_position',$adminColor->toastr_position);
        }


        if ($request->background_type == "image") {
            $file = $request->file('background_image');
            if ($request->hasFile('background_image')) {
                $filename = $this->saveImage($file, 1400, 1920);
            } else {
                $filename = $adminColor->background_image;
            }
            $adminColor->background_color = NULL;
            $adminColor->background_image = $filename;
            $adminColor->save();
        } else {
            $adminColor->background_color = $request->background_color;
            $adminColor->background_image = NULL;
            $adminColor->save();
        }
    }



    public function destroy($id)
    {
        $color = AdminColor::findOrFail($id);
        if ($color->is_active != 1 && $color->id != 1) {
            $color->delete();
        }
    }



    public function activate($id)
    {
        DB::transaction(function () use ($id) {
            $color = AdminColor::findOrFail($id);
            $activeColor = AdminColor::where('is_active', 1)->first();
            $activeColor->is_active = 0;
            $activeColor->save();
            $color->is_active = 1;
            $color->save();
            setEnv('toastr_time',$color->toastr_time);
            setEnv('toastr_position',$color->toastr_position);
        });
    }



    public function getSingle($id)
    {
        return AdminColor::findOrFail($id);
    }



    public function clone($id)
    {
        $adminColor = AdminColor::findOrFail($id);
        $newColor = $adminColor->replicate();
        $newColor->title = "Copy of ".$newColor->title;
        $newColor->is_active = 0;
        $newColor->save();
    }
}
