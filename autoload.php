<?php
/**
 * Created by PhpStorm.
 * User: anhdiepmmk
 * Date: 7/4/2017
 * Time: 8:37 AM
 */
define('BASE_PATH', realpath(dirname(__FILE__)));
// Auto load all class by namespace in folder app (all code logic write in folder app)
spl_autoload_register(function ($class) {
    $filename = BASE_PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    include($filename);
});
