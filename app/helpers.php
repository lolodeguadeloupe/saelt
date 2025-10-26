<?php

use Carbon\Carbon;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

if (!function_exists('currentRouteActive')) {

    function currentRouteActive(...$routes)
    {
        foreach ($routes as $route) {
            if (Route::currentRouteNamed($route))
                return 'active';
        }
    }
}

if (!function_exists('currentChildActive')) {

    function currentChildActive($children)
    {
        foreach ($children as $child) {
            if (Route::currentRouteNamed($child['route']))
                return 'active';
        }
    }
}

if (!function_exists('menuOpen')) {

    function menuOpen($children)
    {
        foreach ($children as $child) {
            if (Route::currentRouteNamed($child['route']))
                return 'menu-open';
        }
    }
}

if (!function_exists('isRole')) {

    function isRole($role)
    {
        return auth()->user()->role === $role;
    }
}

if (!function_exists('base_url')) {

    function base_url(string $path = '')
    {
        return config('app.url') . $path;
    }
}

if (!function_exists('is_active_url')) {

    function is_active_url(array $path = [])
    {
        for ($index = 0; $index < count($path); $index++) {
            if (strcmp(url()->current(), $path[$index]) == 0)
                return true;
        }
        return false;
    }
}

/*
Vue.prototype.$countEtoil = (etoil) => {
    console.log(etoil)
    if (typeof etoil == 'undefined' || etoil == null || isNaN(etoil)) {
        return '';
    } else {
        var _etoil = '';
        for (var k = 0; k < parseInt(etoil); k++) {
            _etoil = _etoil + ' ★';
        }
        return _etoil;
    }
}
*/
if (!function_exists('count_etoil')) {

    function count_etoil($nb_etoil = 0)
    {
        if (isset($nb_etoil)) {
            $etoil = '';
            for ($k = 0; $k < intval($nb_etoil); $k++) {
                $etoil = $etoil . ' ★';
            }
            return $etoil;
        }
        return '';
    }
}

/* */
if (!function_exists('parse_date')) {
    function parse_date($date, $parse = true)
    {
        $date = new Carbon($date);
        if ($parse) {
            return $date->utcOffset(180);
        }
        return $date;
    }
}

if (!function_exists('diff_days')) {
    function diff_days($date1, $date2, $parse = false)
    {
        $d1 = new Carbon($date1);
        $d2 = new Carbon($date2);
        if ($parse) {
            $d1 = $d1->utcOffset(180);
            $d2 = $d2->utcOffset(180);
        }
        return $d2->diffInDays($d1);
    }
}

if (!function_exists('add_days')) {
    function add_days($date1, $day, $parse = false)
    {
        $d1 = new Carbon($date1);
        if ($parse) {
            $d1 = $d1->utcOffset(180);
        }
        $d1->addDays($day);
        return $d1;
    }
}


if (!function_exists('logo')) {
    function logo()
    {
        $logo = asset('assets/img/logo.png');
        $app = DB::table('app_config')->first();
        return $app->logo == null ? $logo : asset($app->logo);
    }
}

if (!function_exists('name')) {
    function name()
    {
        $app = DB::table('app_config')->first();
        return $app->nom == null ? '' : $app->nom;
    }
}

if (!function_exists('code_country')) {
    function code_country()
    {
        if (Storage::exists('CountryCodes.json')) {
            $contents = Storage::get('CountryCodes.json');
            return json_decode($contents);
        }
        return [];
    }
}

if (!function_exists('parse_date_string')) {
    function parse_date_string($date, $parse = false)
    {
        $mydate = [
            'fr' => [
                'month' => ['Janvier', 'Fevrier', 'Mars', 'Avril', 'May', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                'week' => ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']
            ]
        ];

        $date = new Carbon($date);
        if ($parse == true) {
            $date = $date->utcOffset(180);
        }

        return $mydate['fr']['week'][$date->dayOfWeek] . ' ' . $date->day . ' ' . $mydate['fr']['month'][$date->month - 1] . ' ' . $date->year;
    }
}
