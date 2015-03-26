<?php
/**
 * User: bazil
 * Date: 26.03.15
 * Time: 11:34
 */

namespace Notifire;

/**
 * Class NotiException
 * @package Notifire
 */
class NotiException extends \Exception
{
    /**
     * Really we need a scream about exception?
     * @var bool
     */
    private static $_isQuiet = true;

    //Message must be required
    public function __construct($message, $code = 0, Exception $previous = null) {

        parent::__construct($message, $code, $previous);
    }

    //Overload function
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: \n {$this->message}\n";
    }

    /**
     * Mute or unmute our exceptions
     * @param $isQuiet
     */
    public static function setOutputType($isQuiet)
    {
        self::$_isQuiet = $isQuiet;
    }

    /*
     * Check status
     */
    public static function isQuiet()
    {
        return self::$_isQuiet;
    }

    public function execException()
    {
        if(self::$_isQuiet)
            $this->quiet();
        else
            $this->scream();
    }

    /**
     * Method to output exception to front
     */
    private function scream()
    {
        echo PHP_EOL . $this . PHP_EOL;
    }

    /**
     * Method to output exception to the log
     */
    private function quiet()
    {
        $logFile = fopen('./logs/' . date('d_m_Y'), 'a+');

        $msg = "=============== " . date('H:m:s') . " ====================\n";
        $msg .= $this;
        $msg .= "==========================================================\n";

        fwrite($logFile,$msg);

        fclose($logFile);
    }
}