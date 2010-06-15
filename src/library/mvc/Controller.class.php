<?php

require_once 'Layout.class.php';

abstract Class Controller {

    function __construct() {
        
    }

    abstract function index();
}

