<?php

require_once __SITE_PATH . '/library/mvc/' . 'Controller.class.php';
require_once __SITE_PATH . '/library/mvc/' . 'Registry.class.php';
require_once __SITE_PATH . '/library/mvc/' . 'Router.class.php';
require_once __SITE_PATH . '/library/mvc/' . 'View.class.php';
/*** auto load model classes ** */

define('__CONTROLLER_PATH', __SITE_PATH . '/controllers/');
define('__MODEL_PATH', __SITE_PATH . '/models/');
define('__VIEW_PATH', __SITE_PATH . '/views/');
define('__LAYOUT_PATH', __VIEW_PATH . '/layouts/');

define('__LIBRARY_PATH', __SITE_PATH . '/library/');
define('__CONF_PATH', __SITE_PATH . '/conf/');

function __autoload($class_name) {
    $filename = strtolower($class_name) . '.class.php';
    $file = __SITE_PATH . '/model/' . $filename;

    if (file_exists($file) == false) {
        return false;
    }
    include ($file);
}

Registry::init();
