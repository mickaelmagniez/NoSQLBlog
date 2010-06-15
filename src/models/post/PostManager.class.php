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

}

