<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @author Achmad Munandar
 */
class Generator
{

    public static function uuid($table)
    {
        $uuid = (string)Str::uuid();
        if (DB::table($table)->where('id',
                $uuid)->first() != null) {
            return self::uuid($table);
        }
        return $uuid;
    }

}