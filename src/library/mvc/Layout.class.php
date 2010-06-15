<?php

require_once dirname(__FILE__) . '/View.class.php';

class Layout {

    protected $msTitle;
    protected $maPlaceholders;
    protected $msLayoutName;

    /**
     * @param string $psLayoutName
     */
    public function __construct($psLayoutName = 'Layout.phtml' ) {
        $this->msTitle = "";
        $this->maPlaceholders = array();
        $this->msLayoutName = $psLayoutName;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->msTitle;
    }

    /**
     *
     * @param string $psTitle
     */
    public function setTitle($psTitle ) {
        $this->msTitle = $psTitle;
    }

    /**
     * @param String $psName
     * @return String
     */
    public function placeholder($psName ) {
        if (!isset($this->maPlaceholders [$psName])) {
            return '';
        }
        return $this->maPlaceholders [$psName];
    }

    /**
     * @param String $psName
     * @param String $psContent
     */
    public function setPlaceholder($psName, $psContent ) {
        $this->maPlaceholders [$psName] = $psContent;
    }

    public function partial($psView) {
        include (__VIEW_PATH . $psView);
    }

    public function render() {
        if (!file_exists($this->msLayoutName)) {
            throw new Exception(
                    "unknown layout " . $this->msLayoutName);
        }
        include ( $this->msLayoutName );
    }

}

