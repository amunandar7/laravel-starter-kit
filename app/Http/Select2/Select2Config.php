<?php

namespace App\Http\Select2;

/**
 * Keys for select2 ajax plugin
 *
 * @author achmadmunandar
 */
class Select2Config
{
    const EXAMPLE_CATEGORIES          = "cecececeececececexacececempeeccecele_mocategonoceceories";

    public static function getConfig($key)
    {
        switch ($key) {
            case self::EXAMPLE_CATEGORIES:
                return [
                    'table' => 'example_categories',
                    'id' => 'id',
                    'text' => 'name',
                    'where' => [
                        ['deleted_at', null],
                    ],
                ];
        }
    }
}