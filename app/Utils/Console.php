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
     * Auto loop callback if return false
     * @param $callback
     * @return bool or callback data
     */
    public static function loop($callback)
    {
        do {
            $done = $callback();
        } while (is_bool($done) && !$done);
        return $done;
    }

    /**
     * Get input from keyboard
     * @return string
     */
    public static function readLine()
    {
        /**
         * use stream_get_line api if you are Windows
         * use readline api if you are Linux or MAC
         */
        if (PHP_OS == 'WINNT') {
            echo '$ ';
            $line = stream_get_line(STDIN, 1024, PHP_EOL);
        } else {
            $line = readline('$ ');
        }
        return $line;
    }

    /**
     * Print message to screen without break line
     * @param $message
     */
    public static function write($message)
    {
        echo $message;
    }

    /**
     * Print message to screen with break line
     * @param $message
     */
    public static function writeLine($message)
    {
        self::write($message . PHP_EOL);
    }

    /**
     * Reset console screen to blank
     */
    public static function clearScreen()
    {
        /**
         * use cls for windows users
         * use clear for linux users
         */
        if (PHP_OS == 'WINNT') {
            system('cls');
        } else {
            system('clear');
        }
    }
}