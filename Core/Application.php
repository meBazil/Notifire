<?php
/**
 * User: bazil
 * Date: 26.03.15
 * Time: 11:32
 */

namespace Notifire;

/**
 * Class Application
 * @package Notifire
 */
class Application
{
    /**
     * @var array
     */
    private $_config = array();

    /**
     * Instance of current message for next scaling message class
     * @var bool
     */
    private $_currentMessage = false;

    /**
     * Sender
     * @var bool
     */
    private $_provider = false;

    /**
     * Load config and check of options
     */
    public function __construct()
    {
        include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config.php';

        $this->_config = $config;

        try
        {
            $this->_checkConfig();
        }
        catch(NotiException $ex)
        {
            $ex->execException();
        }
    }

    /**
     * Send message to chanel
     * @param string $msg message to channel
     * @param string $typeOfMessage string or type
     * @param array $options additional messages settings
     */
    public function sendMessage($msg, $typeOfMessage = "default", $options = array())
    {
        try
        {
            $this->_checkConfig();

            $newMessage = new Message($msg, $options);

            if($options)
            {
                $options['username'] = $this->_config['username'];
                $options['channel']  = $this->_config['channel'];

                $newAttachment = new Attachment($options['title'], $options['value'], $options);
                $newMessage->appendAttachment($newAttachment);
            }

            $preparedPackage = $newMessage->prepare($this->_config['channel'], $this->_config['username']);

            $result = $this->getProvider()->send($preparedPackage);
        }
        catch(NotiException $ex)
        {
            $ex->execException();
        }
    }

    /**
     * Get instance of provider
     * @return bool|Provider
     */
    public function getProvider()
    {
        if(!$this->_provider)
            $this->_provider = new Provider($this->_config);

        return $this->_provider;
    }

    /**
     * Check configuration file
     * @throws NotiException
     */
    private function _checkConfig()
    {
        $msg = '';

        foreach($this->_config as $key => $value)
        {
            if(empty($value))
                $msg .= ' ' .$key . ' must be filled.' . ((NotiException::isQuiet()) ? "\n" : PHP_EOL);
        }

        if(!empty($msg))
            throw new NotiException($msg, 1);
    }
}