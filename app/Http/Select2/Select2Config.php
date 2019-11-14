<?php

namespace App\Http\Select2;

/**
 * Keys for select2 ajax plugin
 *
 * @author achmadmunandar
 */
class Select2Config
{
    const DOCTOR          = "DcscsscrvvrOscsccCvtbbtfffvTececbttbbtecOvrrrvttbR";
    const CLINIC          = "CddineindeLefueufneifefIeifnefefiefNefuefniefefIefeC";
    const COMPANY         = "82eh9ue2ne2idCOedbjkMPchbdchjbhjANjhdYn2odd2unopd2";
    const INSURANCE       = "djkbcdINdcnbdSURdcjnblmANCEn2odh379u3ndid2unopd2";
    const PATIENT         = "PwsiownATedionede73g3gdd3hu9p3duhd3h3iIENedijedenedT";
    const VILLAGES        = "Visxonso;Ibjeejcl;ecLeuoelLAecjenjceknGecjkceeckEececS";
    const DISTRICT        = "DefefefefmIeffeefSeffefeTfefeRefefIfeefCefeffeeefnjfeT";
    const REGENCIES       = "CnjwidnwdibndwIdindwdwTdwnkdwdwIefkoene37E93u3du9u93n3u";
    const FAQ_CATEGORIES  = "FdcjndcAdcjkndQ_CdccddccdATdcccdcdEGOdcdcRIdcdcES";
    const BLOG_CATEGORIES = "BcdLf4444f4fOf4f4Gf44ff4f4_f4f4f4Cf4f4A4ff44Tf44fE24G42O42R42I424ES";

    public static function getConfig($key)
    {
        switch ($key) {
            case self::DOCTOR:
                return [
                    'table' => 'go_user_detail',
                    'id' => 'id',
                    'text' => 'name',
                    'where' => [
                        ['user_type', \App\Enums\UserType::DOCTOR],
                        ['deleted_at', null],
                    ],
                ];
            case self::CLINIC:
                return [
                    'table' => 'go_user_detail',
                    'id' => 'id',
                    'text' => 'name',
                    'where' => [
                        ['user_type', \App\Enums\UserType::CLINIC],
                        ['deleted_at', null],
                    ],
                ];
            case self::COMPANY:
                return [
                    'table' => 'go_user_detail',
                    'id' => 'id',
                    'text' => 'name',
                    'where' => [
                        ['user_type', \App\Enums\UserType::COMPANY],
                        ['deleted_at', null],
                    ],
                ];
            case self::INSURANCE:
                return [
                    'table' => 'go_user_detail',
                    'id' => 'id',
                    'text' => 'name',
                    'where' => [
                        ['user_type', \App\Enums\UserType::INSURANCE],
                        ['deleted_at', null],
                    ],
                ];
            case self::VILLAGES:
                return [
                    'table' => 'villages',
                    'leftJoin' => [
                        ["districts", "districts.id", "=", "villages.district_id"],
                        ["regencies", "regencies.id", "=", "districts.regency_id"],
                        ["provinces", "provinces.id", "=", "regencies.province_id"],
                    ],
                    'id' => 'villages.id',
                    'text' => ['villages.name', 'districts.name', 'regencies.name',
                        'provinces.name']
                ];
            case self::DISTRICT:
                return [
                    'table' => 'districts',
                    'leftJoin' => [
                        ["regencies", "regencies.id", "=", "districts.regency_id"],
                        ["provinces", "provinces.id", "=", "regencies.province_id"],
                    ],
                    'id' => 'districts.id',
                    'text' => ['districts.name', 'regencies.name',
                        'provinces.name']
                ];
            case self::REGENCIES:
                return [
                    'table' => 'regencies',
                    'leftJoin' => [
                        ["provinces", "provinces.id", "=", "regencies.province_id"],
                    ],
                    'id' => 'regencies.id',
                    'text' => ['regencies.name', 'provinces.name']
                ];
            case self::FAQ_CATEGORIES:
                return [
                    'table' => 'faq_categories',
                    'id' => 'id',
                    'text' => 'name',
                    'where' => [
                        ['deleted_at', null],
                    ],
                ];
            case self::BLOG_CATEGORIES:
                return [
                    'table' => 'blog_categories',
                    'id' => 'id',
                    'text' => 'name',
                    'where' => [
                        ['deleted_at', null],
                    ],
                ];
        }
    }
}