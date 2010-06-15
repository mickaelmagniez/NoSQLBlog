<?php

define('__SITE_PATH', realpath(dirname(__FILE__)));

require __SITE_PATH . '/conf/init.conf.php';

$oRouter = new Router();
$oRouter->setPath(__SITE_PATH . '/controllers');
$oRouter->process();
