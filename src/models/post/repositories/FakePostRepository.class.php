<?php

require_once __MODEL_PATH . 'post/repositories/IPostRepository.interface.php';
require_once __MODEL_PATH . 'post/Post.class.php';

class FakePostRepository implements IPostRepository {

    /**
     * @param integer $_iCount
     * @return array
     */
    public function getLastPosts($_iCount = 10) {
        $aPosts = array();
        for ($i = 0; $i < $_iCount; $i++) {
            $oPost = new Post();
            $oPost->id = $i;
            $oPost->title = 'Post ' . $i;
            $oPost->text = 'blablabla';
            $aPosts[] = $oPost;
        }
        return $aPosts;
    }

	/**
     * @param Post $_oPost
     * @return boolean
     */
    public function insertPost($_oPost) {
		return true;
	}

}

