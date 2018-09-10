<?php

use Illuminate\Support\Debug\Dumper;

if ( ! function_exists('d'))
{
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed
     * @return void
     */
    function d()
    {
        array_map(function ($x)
        {
            (new \Illuminate\Support\Debug\Dumper())->dump($x);
        }, func_get_args());
    }
}

if ( ! function_exists('storage_pulic_path'))
{
    function storage_public_path($path = '', $absolute = true)
    {
        if ($absolute)
        {
            return app_storage_path('app/public/' . $path);
        }

        return 'storage/app/public/' . $path;
    }
}

if ( ! function_exists('storage_private_path'))
{
    function storage_private_path($path = '', $absolute = true)
    {
        if ($absolute)
        {
            return app_storage_path('app/private/' . $path);
        }

        return 'storage/app/private/' . $path;
    }
}

if ( ! function_exists('app_number_format'))
{
    function app_number_format($number, $decimals = 2, $dec_point = ',', $thousands_sep = '&nbsp;')
    {
        return number_format($number, $decimals, $dec_point, $thousands_sep);
    }
}

if ( ! function_exists('display_weight'))
{
    function display_weight($weight)
    {
        if ($weight < 1)
        {
            return ($weight / 1000) . '&nbsp;g';
        } else
        {
            return round($weight, 3) . '&nbsp;kg';
        }
    }
}

if ( ! function_exists('display_date'))
{
    function display_date($date, $format = 'd/m/Y', $default_value = '/')
    {
        if ($date && $date instanceof \Carbon\Carbon)
        {
            return $date->format($format);
        }

        return $default_value;
    }
}

/*
|--------------------------------------------------------------------------
| array_get_values
|--------------------------------------------------------------------------
|
| Retourne les valeurs des clés d'un tableau multidimensionnel
|
*/
if ( ! function_exists('array_get_values'))
{
    function array_get_values($array, $keys)
    {
        $new = [];

        foreach ($array as $key => $value)
        {
            if (in_array($key, $keys))
            {
                $new[$key] = $array[$key];
            }
        }

        return $new;
    }
}

/**
 * Retourne le dossier storage pour les applications sur lesquelles il y a l'intégration continue.
 * Sinon le dossier récupéré est xxx/releases/xxxxx -
 * Au bout de deux nouvelles versions ce dossier est supprimé, et les uploads ne sont plus disponible.
 */
if ( ! function_exists('app_storage_path'))
{
    function app_storage_path($path = '')
    {
        error_reporting(0);
        $storage_path = storage_path($path);

        try
        {
            if (chdir(base_path('../../shared/storage/')))
            {
                $storage_path = getcwd() . DIRECTORY_SEPARATOR . $path;
            }
        } catch (Exception $e)
        {
            if (env('APP_ENV') != 'local')
            {
                \Log::error('##############################################################');
                \Log::error(base_path('../../shared/storage/') . ' DOESN\'T EXISTS !');
                \Log::error('##############################################################');
            }
        }

        return $storage_path;
    }
}