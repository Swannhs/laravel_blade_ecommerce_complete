<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadFileController extends Controller
{

    public function __construct()
    {
        $this->middleware(['maintenance_mode']);
    }

    public function upload_image(Request $request){

    	$request->validate([
            'files.*' => [
                'required',
                'image',
                'mimes:jpeg,jpg,bmp,png,svg,gif'
            ],
        ], [], [
            'files.*' => 'File'
        ]);
        if (!file_exists(asset_path('uploads/editor-image'))) {
            mkdir(asset_path('uploads/editor-image'), 0777, true);
        }
    	$files = $request->files;
    	$image_url = [];
        foreach ($files as $file) {
        	foreach($file as $k => $f){

	            $fileName = $f->getClientOriginalName() . time() . "." . $f->getClientOriginalExtension();
	            $f->move(asset_path('uploads/editor-image/'), $fileName);
	            $image_url[$k] = asset(asset_path('uploads/editor-image/') . $fileName);

        	}
        }

        return response()->json($image_url);
    }
}
