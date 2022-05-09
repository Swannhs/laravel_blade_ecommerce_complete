<?php


use Illuminate\Support\Facades\File;
use Modules\MenuManager\Entities\Sidebar;

if (!function_exists('generate_normal_translated_select_option')) {
    function generate_normal_translated_select_option($data): array
    {
        $options = array();
        foreach ($data as $key => $value) {
            $options[$value] = trans('list.' . $value);
        }
        

        return $options;
    }
}


if (!function_exists('get_account_var')) {
    function get_account_var($list): array
    {
        $file = module_path('Account', 'Resources/var/' . $list . '.json');
        return File::exists($file) ? json_decode(file_get_contents($file), true) : [];
    }
}

if (!function_exists('spn_active_link')) {
    function spn_active_link($route_or_path, $class = 'active')
    {
        if (is_array($route_or_path)) {
            foreach ($route_or_path as $route) {
                if (request()->is($route)) {
                    return $class;
                }
            }
            return in_array(request()->route()->getName(), $route_or_path) ? $class : false;
        } else {
            if (request()->route()->getName() == $route_or_path) {
                return $class;
            }

            if (request()->is($route_or_path)) {
                return $class;
            }
        }

        return false;
    }
}


if (!function_exists('spn_nav_item_open')) {
    function spn_nav_item_open($data, $default_class = 'active')
    {
        foreach ($data as $d) {
            if (spn_active_link($d, true)) {
                return $default_class;
            }
        }
        return false;
    }
}

if (!function_exists('populate_status')) {
    function populate_status($status)
    {
        if ($status) {
            return '<span class="badge_1">' . __('common.active') . '</span>';
        } else {
            return '<span class="badge_2">' . __('common.in-active') . '</span>';
        }
    }
}

if (!function_exists('amountFormat')) {
    function amountFormat($amount)
    {
        return single_price($amount);
    }
}

if (!function_exists('dateFormat')) {
    function dateFormat($date)
    {
        return dateConvert($date);
    }
}
if (!function_exists('gv')) {

    function gv($params, $key, $default = null)
    {
        return (isset($params[$key]) && $params[$key]) ? $params[$key] : $default;
    }
}

if (!function_exists('gbv')) {
    function gbv($params, $key)
    {
        return (isset($params[$key]) && $params[$key]) ? 1 : 0;
    }
}
