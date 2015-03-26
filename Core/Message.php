<?php
/**
 * User: bazil
 * Date: 26.03.15
 * Time: 14:03
 */

namespace Notifire;

/**
 * Class Message
 * @package Notifire
 */
class Message
{
    /**
     * @var bool
     */
    private $_text = false;

    /**
     * @var bool
     */
    private $_icon = ":ghost:";

    /**
     * @var bool
     */
    private $_attachment = false;

    /**
     * @param $text
     * @param array $options
     * @throws NotiException
     */
    public function __construct($text, $options = array())
    {
        if(!$text)
            throw new NotiException('Text can not be empty.' , 2);

        $this->_text = $text;

        if(!empty($options['icon']))
            $this->_icon = $options['icon'];
    }

    /**
     * @param Attachment $attach
     */
    public function appendAttachment(Attachment $attach)
    {
        $this->_attachment = $attach;
    }

    /**
     * Remove attachment
     */
    public function deleteAttachment()
    {
        $this->_attachment = false;
    }

    /**
     * Return formatted json of message with attachment
     * @param $channel
     * @param $username
     * @return string
     * @throws NotiException
     */
    public function prepare($channel, $username)
    {
        if(!$channel || !$username)
            throw new NotiException('Please use channel and username to prepare message.', 4);

        $result = array(
            "channel"  => $channel,
            "username" => $username,
            "text"     => $this->_text,
            "icon_emoji" => $this->_icon
        );

        if($this->_attachment)
            $result["attachments"][] = $this->_attachment->prepare();

        return json_encode($result);
    }

}