<?php
/**
 * Created by PhpStorm.
 * User: anhdiepmmk
 * Date: 7/5/2017
 * Time: 9:20 AM
 */

namespace Models;


class SequenceAccount
{
    private static $sequence = 0;

    /**
     * Auto generate id for account object
     * @return int
     */
    public static function getSequence()
    {
        return ++static::$sequence;
    }

}