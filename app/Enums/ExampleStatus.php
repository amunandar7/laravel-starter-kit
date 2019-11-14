<?php

namespace App\Enums;


class ExampleStatus
{
    const TODO = 0;
    const IN_PROGRESS = 1;
    const DONE = 2;
    const CANCELED = 3;

    public static function getLabels() {
        return [
          self::TODO => "TODO",
          self::IN_PROGRESS => "IN_PROGRESS",
          self::DONE => "DONE",
          self::CANCELED => "CANCELED",
        ];
    }

}