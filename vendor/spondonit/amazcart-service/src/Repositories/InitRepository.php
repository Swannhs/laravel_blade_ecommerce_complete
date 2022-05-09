<?php

namespace SpondonIt\AmazCartService\Repositories;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Modules\Appearance\Entities\Header;
use Modules\FooterSetting\Entities\FooterWidget;
use Modules\GeneralSetting\Entities\BusinessSetting;
use Modules\GeneralSetting\Entities\GeneralSetting;
use Modules\Menu\Entities\Menu;
use Modules\RolePermission\Entities\Role;
use Modules\Setup\Entities\DashboardSetup;
use Nwidart\Modules\Facades\Module;
use Modules\ModuleManager\Entities\InfixModuleManager;
use Modules\Appearance\Entities\Theme;
use Modules\GeneralSetting\Entities\Currency;
use Modules\Language\Entities\Language;


class InitRepository
{

    public function init()
    {
        config([
            'app.item' => '34962179',
            'spondonit.module_manager_model' => InfixModuleManager::class,
            'spondonit.module_manager_table' => 'infix_module_managers',

            'spondonit.settings_model' => GeneralSetting::class,
            'spondonit.module_model' => Module::class,

            'spondonit.user_model' => \App\Models\User::class,
            'spondonit.settings_table' => 'general_settings',
            'spondonit.database_file' => 'wchat.sql',
            'spondonit.php_version' => 7.4
        ]);
    }


    public function config(){

        app()->singleton('permission_list', function() {
            return Role::with(['permissions' => function($query){
                $query->select('route','module_id','parent_id','role_permission.role_id');
            }])->get(['id','name']);
        });


        app()->singleton('business_settings', function () {
            return BusinessSetting::select('category_type', 'type', 'status', 'id')->get();
        });

        app()->singleton('general_setting', function () {
            return GeneralSetting::first();
        });

        config([
            'settings' => app('general_setting'),
            'bus_setting' => ''
        ]);
        
        app()->singleton('dashboard_setup', function () {
            return DashboardSetup::select('type', 'is_active','id')->get();
        });

        app()->singleton('theme',function(){
            return Theme::where('is_active', 1)->first();
        });

        app()->singleton('currencies', function(){
            return Currency::where('status', 1)->get();
        });

        app()->singleton('langs', function(){
            return Language::where('status',1)->get();
        });

        app()->singleton('user_currency', function(){
            if(auth()->check()){
                return Currency::where('id', auth()->user()->currency_id)->first();
            }elseif (session()->get('currency')){
                return Currency::where('id', session()->get('currency'))->first();
            }else{
                return null;
            }
        });

        app()->singleton('current_lang', function(){
            if(auth()->check()){
                return Language::where('code', auth()->user()->lang_code)->select('rtl')->first();
            }elseif (\Illuminate\Support\Facades\Session::get('locale')) {
                $locale = \Illuminate\Support\Facades\Session::get('locale');
                return Language::where('code', $locale)->select('rtl')->first();
            }else{
                return Language::where('code', app('general_setting')->language_code)->select('rtl')->first();
            }
        });

            
        View::composer([theme('partials._newsletter')], function ($view) {
            $data['subscribeContent'] = Cache::rememberForever('suscriptionContent', function () {
                return DB::table('subscribe_contents')->first();
            });
            $view->with($data);
        });

        View::composer([theme('partials._subscription_modal')], function ($view) {
            $data['popupContent'] = Cache::rememberForever('popupContent', function () {
                return \Modules\FrontendCMS\Entities\SubscribeContent::findOrFail(2);
            });
            $view->with($data);
        });
            
        View::composer([theme('partials._newsletter')], function ($view) {
            $data['FeatureList'] = Cache::rememberForever('featureContent', function () {
                return DB::table('features')->where('status', 1)->get();
            });
            $view->with($data);
        });

        View::composer([theme('partials._footer')], function ($view) {

            $data['sectionWidgets'] = Cache::rememberForever('footerWidget', function () {
                return FooterWidget::with('pageData')->where('status', 1)->get();
            });
            $view->with($data);
        });

        View::composer([theme('partials._mega_menu'),theme('partials._mega_menu_small')], function ($view) {
   

            $data['menus'] = Cache::rememberForever('MegaMenu', function () {
                return Menu::with(['menus' => function($menus){
                    return $menus->with(['menu' => function($menu){
                        return $menu->with(['rightPanelData.category', 'bottomPanelData.brand', 'columns' => function($columns){
                            return $columns->with(['elements' => function($elements){
                                return $elements->with(['category', 'brand', 'tag', 'product']);
                            }]);
                        }]);
                    }]);
                }])
                ->where('menu_position', 'main_menu')->where('status', 1)->where('has_parent', null)->orderBy('order_by')->get();
            });
            $data['headers'] = Cache::rememberForever('HeaderSection', function () {
                return Header::all();
            });
            $view->with($data);
        });
    }

}
