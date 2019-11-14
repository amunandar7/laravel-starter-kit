<?php

namespace App\Helpers;

/**
 * @author Achmad Munandar
 */
class StringHelper
{

    public static function humanize($str)
    {
        $str = trim(strtolower($str));
        $str = str_replace("_", " ", $str);
        $str = preg_replace('/[^a-z0-9\s+]/', '', $str);
        $str = preg_replace('/\s+/', ' ', $str);
        $str = explode(' ', $str);

        $str = array_map('ucwords', $str);

        return implode(' ', $str);
    }

    public static function price_format($value)
    {
        return number_format($value, 0, ',', '.');
    }

    public static function generate_random_string($length = 10)
    {
        $characters       = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}