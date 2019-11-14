<?php

namespace App\Enums;


class ExampleStatus
{
    const TODO = 0;
    const IN_PROGRESS = 1;
    const DONE = 2;
    const CANCELED = 3;

    public static function get_labels()
    {
        return [
            self::TODO => "TODO",
            self::IN_PROGRESS => "IN PROGRESS",
            self::DONE => "DONE",
            self::CANCELED => "CANCELED",
        ];
    }

    public static function get_bootstrap_labels($status)
    {
        $class = 'bg-aqua';
        if (in_array($status, [self::IN_PROGRESS])) {
            $class = "bg-blue";
        } else if (in_array($status, [self::DONE])) {
            $class = "bg-green";
        } else if (in_array($status, [self::CANCELED])) {
            $class = "bg-red";
        }
        return '<label class="label ' . $class . '">' . self::get_labels()[$status] . '</label>';
    }
}