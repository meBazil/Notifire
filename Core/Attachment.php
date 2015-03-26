<?php
/**
 * User: bazil
 * Date: 26.03.15
 * Time: 14:24
 */

namespace Notifire;

/**
 * Class Attachment
 * @package Notifire
 */
class Attachment
{
    /**
     * @var bool
     */
    private $_title = false;

    /**
     * @var bool
     */
    private $_value = false;

    /**
     * @var array
     */
    private $_options = array(
        'pretext' => false,
        'color'   => "#439FE0",
        'short'   => false,
        'username' => false,
        'channel'  => false
    );

    /**
     * @param $title
     * @param $value
     * @param array $options
     * @throws NotiException
     */
    public function __construct($title, $value, $options = array())
    {
        //if(empty($title) || empty($value))
        //    throw new NotiException('Required fields!', 3);

        $this->_title = $title;
        $this->_value = $value;

        foreach($options as $key => $value)
            if(isset($this->_options[$key]))
                $this->_options[$key] = $value;

    }

    /**
     * Convert object to formatted array
     * @return string
     */
    public function prepare()
    {
        $result = array(
            "fallback" => $this->_options['pretext'],
            "pretext"  => $this->_options['pretext'],
            "color"    => $this->_options['color'],
            "author_name" => $this->_options['username'],
            "author_link" => "https://github.com/meBazil/Notifire/",
            "author_icon" => "http://unicodey.com/emoji-data/img-google-64/1f341.png",
            "fields"   => array(
                array(
                    "title" => $this->_title,
                    "value" => $this->_value,
                    "short" => $this->_options['short']
                )
            )
        );

        return $result;
    }


}