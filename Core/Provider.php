<?php
/**
 * User: bazil
 * Date: 26.03.15
 * Time: 15:51
 */

namespace Notifire;

/**
 * Class Provider
 * @package Notifire
 */
class Provider
{
    /**
     * @var bool|resource
     */
    private $_curl = false;

    /**
     * @param $config
     * @throws NotiException
     */
    public function __construct($config)
    {
        if(!function_exists('curl_version'))
        {
            throw new NotiException('Curl not exist.', 5);
        }

        $s = curl_init();

        curl_setopt($s,CURLOPT_URL, $config['host'] . $config['apiKey']);
        curl_setopt($s,CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($s,CURLOPT_RETURNTRANSFER,true);

        $this->_curl = $s;
    }

    /**
     * @param $message
     * @return mixed
     */
    public function send($message)
    {
        curl_setopt($this->_curl, CURLOPT_POST, true);

        curl_setopt($this->_curl,CURLOPT_POSTFIELDS, "payload={$message}");

        $result = curl_exec($this->_curl);

        return $result;
    }

}