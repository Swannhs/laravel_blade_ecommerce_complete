<?php

if (!function_exists('isModuleActive')) {
    function isModuleActive($module)
    {
        try {
            $haveModule = app('ModuleList')->where('name', $module)->first();

            $is_module_available = 'Modules/' . $module . '/Providers/' . $module . 'ServiceProvider.php';

            if (file_exists($is_module_available)) {
                
                $moduleCheck = \Nwidart\Modules\Facades\Module::find($module)->isEnabled();

                if (!$moduleCheck) {
                    return false;
                }

                if ($haveModule) {
                    if (!empty($haveModule->purchase_code)) {
                        return true;
                    }
                }else{
                    return $moduleCheck;
                }
            }
            return false;
        } catch (\Throwable $th) {

            return false;
        }

    }
}