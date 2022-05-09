<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use File;

trait ImageStore
{
    public static function saveImage($image, $height = null ,$lenght = null)
    {
        if(isset($image)){

            $current_date  = Carbon::now()->format('d-m-Y');

            $host = activeFileStorage();
            if($host == 'AmazonS3'){
                $img = Image::make($image);
                if($height != null && $lenght != null ){
                    $img_size = getimagesize($image);
                    $original_width = $img_size[0];
                    $original_height = $img_size[1];
                    if($original_width > $original_height){
                        // resize the image to a width of 300 and constrain aspect ratio (auto height)
                        $img->resize($lenght, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }elseif($original_width < $original_height){
                        // resize the image to a height of 200 and constrain aspect ratio (auto width)
                        $img->resize(null, $height, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }else{
                        if($lenght>$height){
                            $img->resize(null,$lenght, function($constraint){
                                $constraint->aspectRatio();
                            });
                        }elseif($lenght<$height){
                            $img->resize($height,null, function($constraint){
                                $constraint->aspectRatio();
                            });
                        }else{
                            $img->resize($height,null, function($constraint){
                                $constraint->aspectRatio();
                            });
                        }
                    }
                }
                $path = Storage::disk('s3')->put('images', $img->stream(), 'public');
                $url = Storage::disk('s3')->url($path);
                return $url;

            }else{

                if(!File::isDirectory(asset_path('uploads/images/').$current_date)){
                    File::makeDirectory(asset_path('uploads/images/').$current_date, 0777, true, true);
                }

                $image_extention = str_replace('image/','',Image::make($image)->mime());

                $img = Image::make($image);
                if($height != null && $lenght != null ){
                    $img_size = getimagesize($image);
                    $original_width = $img_size[0];
                    $original_height = $img_size[1];
                    if($original_width > $original_height){
                        // resize the image to a width of 300 and constrain aspect ratio (auto height)
                        $img->resize($lenght, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }elseif($original_width < $original_height){
                        // resize the image to a height of 200 and constrain aspect ratio (auto width)
                        $img->resize(null, $height, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }else{
                        if($lenght>$height){
                            $img->resize(null,$lenght, function($constraint){
                                $constraint->aspectRatio();
                            });
                        }elseif($lenght<$height){
                            $img->resize($height,null, function($constraint){
                                $constraint->aspectRatio();
                            });
                        }else{
                            $img->resize($height,null, function($constraint){
                                $constraint->aspectRatio();
                            });
                        }
                    }
                }

                $img_name_for_db = 'uploads/images/'.$current_date.'/'.uniqid().'.'.$image_extention;
                $img_name_for_file = asset_path($img_name_for_db);

                $img->save($img_name_for_file);
                return $img_name_for_db;
            }


        }else{
            return null ;
        }
    }

    public static function saveFlag($image, $name , $height = null ,$lenght = null)
    {
        if(isset($image)){

            $flag_name = str_replace(' ','-',$name);
            $image_extention = str_replace('image/','',Image::make($image)->mime());

            $img = Image::make($image);
            if($height != null && $lenght != null ){
                $img_size = getimagesize($image);
                $original_width = $img_size[0];
                $original_height = $img_size[1];
                if($original_width > $original_height){
                    // resize the image to a width of 300 and constrain aspect ratio (auto height)
                    $img->resize($lenght, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }elseif($original_width < $original_height){
                    // resize the image to a height of 200 and constrain aspect ratio (auto width)
                    $img->resize(null, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }else{
                    if($lenght>$height){
                        $img->resize(null,$lenght, function($constraint){
                            $constraint->aspectRatio();
                        });
                    }elseif($lenght<$height){
                        $img->resize($height,null, function($constraint){
                            $constraint->aspectRatio();
                        });
                    }else{
                        $img->resize($height,null, function($constraint){
                            $constraint->aspectRatio();
                        });
                    }
                }
            }

            $img_name = 'flags'.'/flag-of-'.$flag_name.'-'.rand(11111,99999).'.'.$image_extention;
            $img_save = asset_path($img_name);
            $img->save($img_save);
            return $img_name;
        }else{
            return null ;
        }
    }


    public static function saveSettingsImage($image, $height = null ,$lenght = null)
    {
        if(isset($image)){
           $current_date  = Carbon::now()->format('d-m-Y');
           $image_extention = str_replace('image/','',Image::make($image)->mime());

            $img = Image::make($image);
            if($height != null && $lenght != null ){
                $img_size = getimagesize($image);
                $original_width = $img_size[0];
                $original_height = $img_size[1];
                if($original_width > $original_height){
                    // resize the image to a width of 300 and constrain aspect ratio (auto height)
                    $img->resize($lenght, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }elseif($original_width < $original_height){
                    // resize the image to a height of 200 and constrain aspect ratio (auto width)
                    $img->resize(null, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }else{
                    if($lenght>$height){
                        $img->resize(null,$lenght, function($constraint){
                            $constraint->aspectRatio();
                        });
                    }elseif($lenght<$height){
                        $img->resize($height,null, function($constraint){
                            $constraint->aspectRatio();
                        });
                    }else{
                        $img->resize($height,null, function($constraint){
                            $constraint->aspectRatio();
                        });
                    }

                }
            }

            $img_name = 'uploads/settings'.'/'.uniqid().'.'.$image_extention;
            $img_save = asset_path($img_name);
            $img->save($img_save);
            return $img_name;
        }else{
            return null ;
        }
    }


    public static function deleteImage($url)
    {
        if(isset($url)){

            if($url){
                if(strpos($url, 'amazonaws.com') != false){
                   return Storage::disk('s3')->delete($url);
                }else{
                    if (File::exists(asset_path($url))) {
                        File::delete(asset_path($url));
                        return true;
                    }else{
                        return false;
                    }
                }

            }else{
                return null;
            }


        }else{
            return null ;
        }
    }

    public function saveAvatar($image, $height = null ,$lenght = null)
    {
        if(isset($image)){
            $current_date  = Carbon::now()->format('d-m-Y');

            if(!File::isDirectory(asset_path('uploads/avatar/').$current_date)){

                File::makeDirectory(asset_path('uploads/avatar/').$current_date, 0777, true, true);

            }

            $image_extention = str_replace('image/','',Image::make($image)->mime());

            $img = Image::make($image);

            if($height != null && $lenght != null ){
                $img_size = getimagesize($image);
                $original_width = $img_size[0];
                $original_height = $img_size[1];
                if($original_width > $original_height){
                    // resize the image to a width of 300 and constrain aspect ratio (auto height)
                    $img->resize($lenght, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }elseif($original_width < $original_height){
                    // resize the image to a height of 200 and constrain aspect ratio (auto width)
                    $img->resize(null, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }else{
                    if($lenght>$height){
                        $img->resize(null,$lenght, function($constraint){
                            $constraint->aspectRatio();
                        });
                    }elseif($lenght<$height){
                        $img->resize($height,null, function($constraint){
                            $constraint->aspectRatio();
                        });
                    }else{
                        $img->resize($height,null, function($constraint){
                            $constraint->aspectRatio();
                        });
                    }
                }
            }

            $img_name = 'uploads/avatar/'.$current_date.'/'.uniqid().'.'.$image_extention;
            $img_save = asset_path($img_name);
            $img->save($img_save);
            return $img_name;
        }else{
            return null ;
        }
    }

    public static function PaymentLogo($image, $height = null ,$lenght = null){
        if(isset($image)){
            $current_date  = Carbon::now()->format('d-m-Y');

            if(!File::isDirectory(asset_path('payment_gateway'))){

                File::makeDirectory(asset_path('payment_gateway'), 0777, true, true);

            }

            $image_extention = str_replace('image/','',Image::make($image)->mime());

            $img = Image::make($image);

            if($height != null && $lenght != null ){
                $img_size = getimagesize($image);
                $original_width = $img_size[0];
                $original_height = $img_size[1];
                if($original_width > $original_height){
                    // resize the image to a width of 300 and constrain aspect ratio (auto height)
                    $img->resize($lenght, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }elseif($original_width < $original_height){
                    // resize the image to a height of 200 and constrain aspect ratio (auto width)
                    $img->resize(null, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }else{
                    if($lenght>$height){
                        $img->resize(null,$lenght, function($constraint){
                            $constraint->aspectRatio();
                        });
                    }elseif($lenght<$height){
                        $img->resize($height,null, function($constraint){
                            $constraint->aspectRatio();
                        });
                    }else{
                        $img->resize($height,null, function($constraint){
                            $constraint->aspectRatio();
                        });
                    }
                }
            }

            $img_name = 'payment_gateway/'.uniqid().'.'.$image_extention;
            $img_save = asset_path($img_name);
            $img->save($img_save);
            return $img_name;
        }else{
            return null ;
        }
    }

    public function savePWAIcon($image){
        if(isset($image)){
            if(!File::isDirectory(asset_path('images/icons'))){
                File::makeDirectory(asset_path('images/icons'), 0777, true, true);
            }

            if (File::exists(asset_path('images/icons/icon-72x72.png'))) {
                File::delete(asset_path('images/icons/icon-72x72.png'));
            }
            if (File::exists(asset_path('images/icons/icon-96x96.png'))) {
                File::delete(asset_path('images/icons/icon-96x96.png'));
            }
            if (File::exists(asset_path('images/icons/icon-128x128.png'))) {
                File::delete(asset_path('images/icons/icon-128x128.png'));
            }
            if (File::exists(asset_path('images/icons/icon-144x144.png'))) {
                File::delete(asset_path('images/icons/icon-144x144.png'));
            }
            if (File::exists(asset_path('images/icons/icon-152x152.png'))) {
                File::delete(asset_path('images/icons/icon-152x152.png'));
            }
            if (File::exists(asset_path('images/icons/icon-192x192.png'))) {
                File::delete(asset_path('images/icons/icon-192x192.png'));
            }
            if (File::exists(asset_path('images/icons/icon-384x384.png'))) {
                File::delete(asset_path('images/icons/icon-384x384.png'));
            }
            if (File::exists(asset_path('images/icons/icon-512x512.png'))) {
                File::delete(asset_path('images/icons/icon-512x512.png'));
            }

            $img = Image::make($image);
            $img->resize(72,72);
            $img_save_72 = asset_path('images/icons/icon-72x72.png');
            $img->save($img_save_72);

            $img->resize(96,96);
            $img_save_96 = asset_path('images/icons/icon-96x96.png');
            $img->save($img_save_96);

            $img->resize(128,128);
            $img_save_128 = asset_path('images/icons/icon-128x128.png');
            $img->save($img_save_128);

            $img->resize(144,144);
            $img_save_144 = asset_path('images/icons/icon-144x144.png');
            $img->save($img_save_144);

            $img->resize(152,152);
            $img_save_152 = asset_path('images/icons/icon-152x152.png');
            $img->save($img_save_152);

            $img->resize(192,192);
            $img_save_192 = asset_path('images/icons/icon-192x192.png');
            $img->save($img_save_192);

            $img->resize(384,384);
            $img_save_384 = asset_path('images/icons/icon-384x384.png');
            $img->save($img_save_384);

            $img->resize(512,512);
            $img_save_512 = asset_path('images/icons/icon-512x512.png');
            $img->save($img_save_512);

            return true;
        }

    }

    public function savePWASplash($image){
        if(isset($image)){
            if(!File::isDirectory(asset_path('images/icons'))){
                File::makeDirectory(asset_path('images/icons'), 0777, true, true);
            }

            $site_log_sizes = [
                ['640', '1136'],
                ['750', '1334'],
                ['828', '1792'],
                ['1125', '2436'],
                ['1242', '2208'],
                ['1242', '2688'],
                ['1536', '2048'],
                ['1668', '2224'],
                ['1668', '2388'],
                ['2048', '2732'],
            ];

            if ($image->extension() != "svg") {
                foreach ($site_log_sizes as $size) {
                    $rowImage = Image::canvas($size[0], $size[1], '#fff');
                    $rowImage->insert($image, 'center');
                    $rowImage->save(asset_path("images/icons/splash-{$size[0]}x{$size[1]}.png"));
                }
            }

            return true;
        }

    }


}
