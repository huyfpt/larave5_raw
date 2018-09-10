<?php

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