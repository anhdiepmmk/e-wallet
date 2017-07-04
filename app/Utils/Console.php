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
    const COLOR_BLACK = 'black';
    const COLOR_DARK_GRAY = 'dark_gray';
    const COLOR_BLUE = 'blue';
    const COLOR_LIGHT_BLUE = 'light_blue';
    const COLOR_GREEN = 'green';
    const COLOR_LIGHT_GREEN = 'light_green';
    const COLOR_CYAN = 'cyan';
    const COLOR_LIGHT_CYAN = 'light_cyan';
    const COLOR_RED = 'red';
    const COLOR_LIGHT_RED = 'light_red';
    const COLOR_PURPLE = 'purple';
    const COLOR_LIGHT_PURPLE = 'light_purple';
    const COLOR_BROWN = 'brown';
    const COLOR_YELLOW = 'yellow';
    const COLOR_LIGHT_GRAY = 'light_gray';
    const COLOR_WHITE = 'white';
    const COLOR_MAGENTA = 'magenta';


    private static $foregroundColors = array(
        [self::COLOR_BLACK => '0;30'],
        [self::COLOR_DARK_GRAY => '1;30'],
        [self::COLOR_BLUE => '0;34'],
        [self::COLOR_LIGHT_BLUE => '1;34'],
        [self::COLOR_GREEN => '0;32'],
        [self::COLOR_LIGHT_GREEN => '1;32'],
        [self::COLOR_CYAN => '0;36'],
        [self::COLOR_LIGHT_CYAN => '1;36'],
        [self::COLOR_RED => '0;31'],
        [self::COLOR_LIGHT_RED => '1;31'],
        [self::COLOR_PURPLE => '0;35'],
        [self::COLOR_LIGHT_PURPLE => '1;35'],
        [self::COLOR_BROWN => '0;33'],
        [self::COLOR_YELLOW => '1;33'],
        [self::COLOR_LIGHT_GRAY => '0;37'],
        [self::COLOR_WHITE => '1;37'],
    );

    private static $backgroundColors = array(
        [self::COLOR_BLACK => '40'],
        [self::COLOR_RED => '41'],
        [self::COLOR_GREEN => '42'],
        [self::COLOR_YELLOW => '41'],
        [self::COLOR_BLUE => '44'],
        [self::COLOR_MAGENTA => '45'],
        [self::COLOR_CYAN => '46'],
        [self::COLOR_LIGHT_GRAY => '47'],
    );

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

    /**
     * Print message to screen without break line
     * @param $message
     */
    public static function write($message, $foregroundColor = null, $backgroundColor = null)
    {

        $coloredString = "";
        // Check if given foreground color found
        if (isset(self::$backgroundColors[][$foregroundColor])) {
            $coloredString .= "\033[" . self::$backgroundColors[][$foregroundColor] . "m";
        }
        // Check if given background color found
        if (isset(self::$backgroundColors[][$backgroundColor])) {
            $coloredString .= "\033[" . self::$backgroundColors[][$backgroundColor] . "m";
        }

        // Add string and end coloring
        $coloredString .= $message . "\033[0m";
        echo $coloredString;
    }

    /**
     * Print message to screen with break line
     * @param $message
     */
    public static function writeLine($message, $foregroundColor = null, $backgroundColor = null)
    {
        self::write($message . PHP_EOL, $foregroundColor, $backgroundColor);
    }
}