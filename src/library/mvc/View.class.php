<?php

class View {

    /**
     * @var String
     */
    private $msTemplateFile;
    /**
     * @var Array
     */
    private $maVariables;

    /**
     * @param string $psTemplateFile
     */
    public function __construct($psTemplateFile ) {
        $this->msTemplateFile = __VIEW_PATH . $psTemplateFile;
        $this->maVariables = array();
    }

    /**
     * @param string $psFile
     */
    protected function run($psFile ) {
        include ( $psFile );
    }

    /**
     * @return String
     */
    public function execute() {
        ob_start ();
        $sContents = '';
        try {
            $this->run($this->msTemplateFile);
            $sContents = ob_get_contents ();
            ob_end_clean ();
        } catch (Exception $e) {
            ob_end_clean ();
            throw $e;
        }

        return $sContents;
    }

    /**
     * @param string $psTemplateFile
     */
    public function partial($psTemplateFile ) {
        $this->run(__VIEW_PATH . $psTemplateFile);
    }

    public function __set($psName, $pValue ) {
        $this->maVariables [$psName] = $pValue;
    }

    public function __get($psName ) {
        if (array_key_exists($psName, $this->maVariables)) {
            return $this->maVariables [$psName];
        }
        return "";
    }

    public function __isset($psName ) {
        return isset($this->maVariables [$psName]);
    }

    public function __unset($psName ) {
        unset($this->maVariables [$psName]);
    }

}

