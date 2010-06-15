<?php

require_once __MODEL_PATH . 'post/PostManager.class.php';

class indexController extends Controller {

    /**
     * @var Layout
     */
    protected $moLayout;

    public function __construct() {
        $this->moLayout = new Layout(__LAYOUT_PATH . '/Layout.phtml');
    }

    public function index() {
        $oView = new View('Posts.phtml');
        $oPostManager = new PostManager();
        $oView->posts = $oPostManager->getLastPosts();;
        $this->moLayout->setPlaceholder('content', $oView->execute());
        $this->render();
    }

    protected function render() {
        $this->moLayout->render();
    }

}
?>