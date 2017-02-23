<?php

namespace go1\util;

class LoTypes
{
    const LEANING_PATHWAY = 'learning_pathway';
    const COURSE          = 'course';
    const MODULE          = 'module';
    const AWARD           = 'award';

    public static function all()
    {
        return [self::LEANING_PATHWAY, self::COURSE, self::MODULE, self::AWARD];
    }

    public static function allTheThing()
    {
        return array_merge(self::all(), LiTypes::all());
    }
}
