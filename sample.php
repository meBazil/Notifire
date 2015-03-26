<?php
/**
 * User: bazil
 * Date: 26.03.15
 * Time: 11:31
 */

use \Notifire\Application as App;

require_once './autoloader.php';

\Notifire\Notifire_Autoloader::register();

\Notifire\NotiException::setOutputType(false);

$app = new App();

$app->sendMessage("test message to me", "default",
    array(
        "pretext"   =>  "some attachment pretext2",
        "title"     =>  "attachment title",
        "value"     =>  "attachment value <http://google.com/|and link>",
        "icon"      =>  ":maple_leaf:"
    )
);