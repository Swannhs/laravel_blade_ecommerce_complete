<?php


namespace App\Traits;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait FileUpload
{
    public function fileUpload($file,$upload_path) {
        if (! File::exists($upload_path)) {
            File::makeDirectory($upload_path, $mode = 0777, true, true);
        }

        if($file->getClientOriginalExtension() == 'pdf'){
            $fileName = '@@-file-@@'.Str::slug(explode('.', $file->getClientOriginalName())[0],'_').'.'.$file->getClientOriginalExtension();
        }else{
            $fileName = '@@-image-@@'.Str::slug(explode('.', $file->getClientOriginalName())[0],'_').'.'.$file->getClientOriginalExtension();
        }
//        .pdf,.jpeg,.jpg,.png,.gif
//        $fileName = Str::slug(explode('.', $file->getClientOriginalName())[0],'_').'@'.time().'.'.$file->getClientOriginalExtension();
        $file->move($upload_path,$fileName);
        return $fileName;
    }

    public function fileUploadAndUpdate($file,$upload_path,$existingFile) {
        if (! File::exists($upload_path)) {
            File::makeDirectory($upload_path, $mode = 0777, true, true);
        }
        if(file_exists($upload_path.'/'.$existingFile)){
            unlink($upload_path.'/'.$existingFile);
        }
        $fileName = Str::slug(explode('.', $file->getClientOriginalName())[0],'_').'@'.time().'.'.$file->getClientOriginalExtension();
        $file->move($upload_path,$fileName);
        return $fileName;
    }

    public function fileDelete($url)
    {
        $file = asset_path('uploads/lead/'.$url);
        if (File::exists($file)) {
            File::delete($file);
        }
    }

}
