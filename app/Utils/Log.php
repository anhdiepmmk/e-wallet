<?php
/**
 * Created by PhpStorm.
 * User: anhdiepmmk
 * Date: 7/4/2017
 * Time: 11:05 AM
 */

namespace Utils;


class Log
{
    const LEVEL_WARNING = 'WARNING';
    const LEVEL_DEBUG = 'DEBUG';
    const LEVEL_INFO = 'INFO';
    const LEVEL_ERROR = 'ERROR';

    const LOG_FOLDER = BASE_PATH . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'stograge' . DIRECTORY_SEPARATOR . 'logs';


    /**
     * Write log message
     * @param $level
     * @param $message
     * @param array $data
     */
    public static function write($level, $message, array $data)
    {
        $fileName = date("m-d-Y") . '.log';
        $filePath = self::LOG_FOLDER . DIRECTORY_SEPARATOR . $fileName;


        $time = date("m-d-Y h:i:s A");
        $body = '[' . $time . '] level.' . $level . '  ' . $message . ' ' . json_encode($data);

        file_put_contents($filePath, $body . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    /**
     * Write log message level warning
     * @param $message
     * @param array $data
     */
    public static function warning($message, array $data)
    {
        self::write(self::LEVEL_WARNING, $message, $data);
    }

    /**
     * Write log message level error
     * @param $message
     * @param array $data
     */
    public static function error($message, array $data)
    {
        self::write(self::LEVEL_ERROR, $message, $data);
    }

    /**
     * Write log message level info
     * @param $message
     * @param array $data
     */
    public static function info($message, array $data)
    {
        self::write(self::LEVEL_INFO, $message, $data);
    }

    /**
     * Write log message level debug
     * @param $message
     * @param array $data
     */
    public static function debug($message, array $data)
    {
        self::write(self::LEVEL_DEBUG, $message, $data);
    }
}