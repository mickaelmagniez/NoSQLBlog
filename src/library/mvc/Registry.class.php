<?php

class Registry {

    /**
     * @var Registry
     */
    protected static $moInstance = null;

    /*
     * @var array
     */
    protected $maVars = array();

    private function __construct() {

    }

    public static function init() {
        if (self::$moInstance === null) {
            self::$moInstance = new self();
        }
        return self::$moInstance;
    }

    /**
     * @set undefined vars
     * @param string $index
     * @param mixed $value
     */
    public function __set($_name, $_value) {
        $this->maVars[$_name] = $_value;
    }

    /**
     * @get variables
     * @param mixed $index
     * @return mixed
     */
    public function __get($_name) {
        return $this->maVars[$_name];
    }

    /**
     * @param string $_name
     * @return mixed
     */
    public function __isset($_name ) {
        return isset($this->maVars[$_name]);
    }

}

