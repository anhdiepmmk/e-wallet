<?php
/**
 * Created by PhpStorm.
 * User: anhdiepmmk
 * Date: 7/4/2017
 * Time: 9:02 AM
 */

namespace Utils;


class Console
{
    /**
     * Get input from keyboard
     * @return string
     */
    public static function readLine()
    {
        if (PHP_OS == 'WINNT') {
            echo '$ ';
            $line = stream_get_line(STDIN, 1024, PHP_EOL);
        } else {
            $line = readline('$ ');
        }
        return $line;
    }

    public static function write($message)
    {
        echo $message;
    }

    public static function writeLine($message)
    {
        echo $message . PHP_EOL;
    }
}