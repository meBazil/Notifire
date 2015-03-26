<?php
/**
 * Created by PhpStorm.
 * User: bazil
 * Date: 26.03.15
 * Time: 12:11
 */

namespace Notifire;

/**
 * Class Notifire_Autoloader
 * @package Notifire
 */
class Notifire_Autoloader
{

    /**
     * Add custom autoload
     */
    public static function register()
    {
        ini_set('unserialize_callback_func', 'spl_autoload_call');
        spl_autoload_register(array('\Notifire\Notifire_Autoloader', 'autoload'));
    }

    /**
     * Autoload classes
     * @param $class
     */
    public static function autoload($class)
    {
        $class = str_replace('Notifire\\', '', $class);

        $file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . $class . '.php';

        if (is_file($file)) {
            require $file;
        }
    }
}