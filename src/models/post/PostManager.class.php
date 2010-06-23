<?php

require_once __MODEL_PATH . 'base/BaseManager.class.php';
require_once __MODEL_PATH . 'post/Post.class.php';
require_once __MODEL_PATH . 'post/repositories/DefaultPostRepository.class.php';

class Postmanager extends BaseManager {

    /**
     * @param integer $_iCount
     * @return array
     */
    public function getLastPosts($_iCount = 10) {
        return $this->getRepository()->getLastPosts($_iCount);
    }

	/**
	 * @param string $_sTag
     * @param integer $_iCount
     * @return array
     */
    public function getLastPostsByTag($_sTag, $_iCount = 10) {
        return $this->getRepository()->getLastPostsByTag($_sTag, $_iCount);
    }

    /**
     * @param integer $_iCount
     * @return array
     */
    public function insertPost($_sTitle, $_sText, $_sTags) {
        $oPost = new Post();
        $oPost->title = $_sTitle;
        $oPost->text = $_sText;
        $oPost->tags = explode(',', $_sTags);
        $oPost->slug = $this->generateSlug($_sTitle);
        return $this->getRepository()->insertPost($oPost);
    }

    /**
     * @return $poRepository
     */
    protected function getRepository() {
        if (!isset($this->moRepository)) {
            $this->moRepository = new DefaultPostRepository();
        }
        return $this->moRepository;
    }

    /**
     * @param iPostRepository $poRepository
     */
    protected function setRepository($poRepository) {
        $this->moRepository = $poRepository;
    }

    /**
     * @param string $_sTitle
     * @return string
     */
    private function generateSlug($_sTitle) {
        return preg_replace('/[^a-zA-Z0-9]/', '-', strtolower($_sTitle));
    }

}

