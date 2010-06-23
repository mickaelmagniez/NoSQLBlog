<?php

class Router {

    protected $msPath;
    protected $maArgs = array();
    protected $msFile;
    protected $msController;
    protected $msAction;

    function __construct() {

    }

    /**
     * @set controller directory path
     * @param string $_path
     * @return void
     */
    function setPath($_sPath) {
        if (is_dir($_sPath) == false) {
            throw new Exception('Invalid controller path: `' . $_sPath . '`');
        }
        $this->msPath = $_sPath;
    }

    /**
     * @load the controller
     */
    public function process() {
        $this->getRoute();
        if (is_readable($this->msFile) === false) {
            die('404 Not Found');
        }

        include $this->msFile;

        $class = $this->msController . 'Controller';
        $controller = new $class();

        /* ** check if the action is callable ** */
        if (is_callable(array($controller, $this->msAction)) == false) {
            $action = 'index';
        } else {
            $action = $this->msAction;
        }
        /* ** run the action ** */
        $controller->$action(array_merge($this->maArgs,$_GET));
    }

    /**
     *
     * @get the controller
     */
    private function getRoute() {
        $sRoute = (empty($_GET['rt'])) ? '' : $_GET['rt'];

        if (empty($sRoute)) {
            $this->msController = 'Index';
            $this->msAction = 'Index';
        } else {
            $aArgs = explode('/', $sRoute);
            $this->msController = $aArgs[0];
            if (isset($aArgs[1])) {
                $this->msAction = $aArgs[1];
            } else {
                $this->msAction = 'Index';
            }
			if (isset($aArgs[2])) {
				$this->maArgs = array_slice($aArgs, 2);
           	}
        }
        $this->msFile = $this->msPath . '/' . $this->msController . 'Controller.class.php';
    }

}

