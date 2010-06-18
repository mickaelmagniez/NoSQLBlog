<?php

require_once __MODEL_PATH . 'post/PostManager.class.php';

class PostController extends Controller {

    /**
     * @var Layout
     */
    protected $moLayout;

    public function __construct() {
        $this->moLayout = new Layout(__LAYOUT_PATH . '/Layout.phtml');
    }

    public function index() {
        $this->last();
    }

    public function last() {
        $oView = new View('Posts.phtml');
        $oPostManager = new PostManager();
        $oView->posts = $oPostManager->getLastPosts();;
        $this->moLayout->setPlaceholder('content', $oView->execute());
        $this->render();
    }

    public function write($_args) {
        if (!isset($_args['title'])) {
            $oView = new View('Write.phtml');
            $oPostManager = new PostManager();
            $oView->posts = $oPostManager->getLastPosts();;
            $this->moLayout->setPlaceholder('content', $oView->execute());
            $this->render();
        } else {
            $oPostManager = new PostManager();
            if ($oPostManager->insertPost($_args['title'], $_args['text'], $_args['tags'])) {
                //header('Location: /');
				$this->last();
            } else {
                $this->write();
            }
        }
    }

    protected function render() {
        $this->moLayout->render();
    }

}

