<?php

use App\Mail\ContactMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use \Modules\Appearance\Entities\Theme;
use Modules\Attendance\Entities\Attendance;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\ImageManagerStatic as Image;
use Modules\Language\Entities\Language;
use Modules\SidebarManager\Entities\Sidebar;

if (!function_exists('theme')) {
    function theme($data)
    {
        $theme = app('theme');
        if ($theme) {
            return 'frontend.' . $theme->folder_path . '.' . $data;
        }
    }

}

 if(!function_exists('contactMail')){
    function contactMail($details){
        return Mail::to(env('MAIL_USERNAME'))->queue(new ContactMail($details));
    }
 }

if (!function_exists('attendanceCheck')) {
    function attendanceCheck($user_id, $type, $date)
    {
        $attendance = Attendance::where('user_id', $user_id)->whereDate('date', Carbon::parse($date)->format('Y-m-d'))->first();
        if ($attendance != null) {
            if ($attendance->attendance == $type) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
}

if (!function_exists('attendanceNote')) {
    function attendanceNote($user_id)
    {
        $todayAttendance = Attendance::where('user_id', $user_id)->where('date', Carbon::today()->toDateString())->first();
        if ($todayAttendance != null) {
            return true;
        } else {
            return false;
        }
    }
}


if (!function_exists('Note')) {
    function Note($user_id)
    {
        $todayAttendance = Attendance::where('user_id', $user_id)->where('date', Carbon::today()->toDateString())->first();
        if ($todayAttendance != null && $todayAttendance->note != null) {
            return $todayAttendance->note;
        } else {
            return false;
        }
    }
}


 if(!function_exists('contactMail')){
    function contactMail($details){
        return MailSend::to('spn21@spondonit.com')->send(new ContactMail($details));
    }
 }



if(!function_exists('is_admin_user')){
    function is_admin_user($id){
        $authIdList=[1,2,3];
        if(in_array($id,$authIdList)){
            return true;
        }
        return false;
    }
 }

if(!function_exists('image_resize')){
    function image_resize(){
        $image=asset('public/uploads/blog/026649a94d244f70d1ce3b08a5a801dd.jpg');
        $img = Image::make('http://amazcart.com/public/uploads/blog/026649a94d244f70d1ce3b08a5a801dd.jpg');
        $resize=$img->resize(320, 200);
        return $img;

    }
 }
if(!function_exists('selling_price')){
    function selling_price ($amount = 0, $discount_type = 1, $discount_amount = 0){
        $discount = 0;
        if($discount_type == 0){
            $discount = ($amount/100) *$discount_amount;
        }if($discount_type == 1){
            $discount = $discount_amount;
        }

        $selling_price = $amount - $discount;
        return $selling_price;
     }
}

if(!function_exists('tax_count')){
    function tax_count($price=0 , $tax_amount=0, $tax_type=0){
        $tax = 0;
        if($tax_type == 0){
            $tax = ($price/100) * $tax_amount;
        }
        if($tax_type == 1){
            $tax = $tax_amount;
        }
        return $tax;
    }
}

if (!function_exists('sidebar_menus')) {
    function sidebar_menus()
    {
        if (!session()->has('menus')) {

            if (\Illuminate\Support\Facades\Auth::user()->sidebars()->exists()) {
                $PermissionList = Sidebar::where('user_id', auth()->id())->orderBy('position', 'asc')->get();
            } else {
                $PermissionList = Sidebar::where('user_id', 0)->orderBy('position', 'asc')->get();
            }
            $data['MainMenuList'] = $PermissionList->where('type', 1);
            $data['SubMenuList'] = $PermissionList->where('type', 2);
            $data['PermissionList'] = $PermissionList;
            $data['actions'] = $PermissionList->where('type', 3);
            session()->put('menus', $data);
            $data = session()->get('menus');
        } else {
            $data = session()->get('menus');
        }
        return $data;
    }
}

if (!function_exists('menuManagerCheck')) {
    function menuManagerCheck($type, $module_id, $route = null)   //type = 1 for main menu,2 for sub menu and 3 for action
    {
        $row = [
            'position' => '',
            'status' => ''
        ];

        $sidebar = sidebar_menus();

        if ($type == 1) {
            $mainMenu = $sidebar['MainMenuList']->where('module_id', $module_id)->first();

            $row = [
                'position' => $mainMenu->position ?? '',
                'status' => $mainMenu->status ?? ''
            ];
        } elseif ($type == 2) {
            $subMenu = $sidebar['SubMenuList']->where('module_id', $module_id)->where('route', $route)->first();

            $row = [
                'position' => $subMenu->position ?? '',

                'status' => $subMenu->status ?? ''


            ];
        } elseif ($type == 3) {
            $actions = $sidebar['actions']->where('module_id', $module_id)->where('route', $route)->first();

            $row = [
                'position' => $actions->position ?? '',

                'status' => $actions->status ?? ''

            ];
        }
        return json_decode(json_encode($row));
    }
}

if (!function_exists('asset_path')) {
    function asset_path($path = null){
        return 'public/'.$path;
    }
}


function setEnv($name, $value)
{
    $path = base_path('.env');
    if (file_exists($path)) {
        file_put_contents($path, str_replace(
            $name . '=' . env($name), $name . '=' . $value, file_get_contents($path)
        ));
    }
}

if (!function_exists('isRtl')) {
    function isRtl()
    {
        if (app('current_lang')->rtl == 1) {
            return true;
        }
        return false;
    }
}

if(!function_exists('getVar')){
    /*
     *  Used to get value-list json
     *  @return array
     */

    function getVar($list) {
        $file = resource_path('var/' . $list . '.json');

        return (File::exists($file)) ? json_decode(file_get_contents($file), true) : [];
    }
}
if (!function_exists('affiliateConfig')) {
    function affiliateConfig($key)
    {
        try {
            if($key){
                if (Cache::has('affiliate_config')) {
                    $affiliate_configs =  Cache::get('affiliate_config');
                    return $affiliate_configs[$key];

                } else {
                    Cache::forget('affiliate_config');
                    $datas = [];
                    foreach (\Modules\Affiliate\Entities\AffiliateConfiguration::get() as  $setting) {
                        $datas[$setting->key] = $setting->value;
                    }
                    Cache::rememberForever('affiliate_config', function () use($datas) {
                        return $datas;
                    });
                    $affiliate_configs =  Cache::get('affiliate_config');
                    return $affiliate_configs[$key];
                }
            }else{
                return false;
            }

        } catch (Exception $exception) {
            return false;
        }
    }
}
if (!function_exists('isAffiliateUser')) {
    function isAffiliateUser()
    {
        try {
            if(auth()->check()){
               if(auth()->user()->affiliate_request ==1){
                   return true;
               }
            }
            return false;

        } catch (Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('hasAffiliateAccess')) {
    function hasAffiliateAccess()
    {
        try {
            if(auth()->check()){
                if(auth()->user()->role->type == 'superadmin'){
                    return true;
                }
                if(auth()->user()->affiliate_request ==1 && auth()->user()->accept_affiliate_request ==1){
                    return true;
                }
            }
            return false;

        } catch (Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('getParentSellerId')) {
    function getParentSellerId()
    {
        $seller_id = 0;
        if (auth()->user()->role->type == 'seller') {
            if(auth()->user()->sub_seller){
                $seller_id = auth()->user()->sub_seller->seller_id;
            }else{
                $seller_id = auth()->id();
            }
        } elseif (auth()->user()->role->type == "superadmin") {
            $seller_id = auth()->user()->id;
        } elseif (auth()->user()->role->type == "staff" || auth()->user()->role->type == "admin") {
            $seller_id = User::first()->id;
        }
        return $seller_id;   
    }
}