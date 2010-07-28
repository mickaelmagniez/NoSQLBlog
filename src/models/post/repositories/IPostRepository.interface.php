<?php
require_once __MODEL_PATH . 'post/Post.class.php';

interface IPostRepository {

    /**
     * Get last x posts
     *
     * @param int $_iCount
     * @param int $_iPage
     * @return array
     */
    public function getLastPosts($_iCount = 5, $_iPage = 1);

	/**
     * Get last x posts by tag
     *
	 * @param string $_sTag
     * @param int $_iCount
     * @param int $_iPage
     * @return array
     */
    public function getLastPostsByTag($_sTag, $_iCount = 5, $_iPage = 1);

    /**
     * Insert a new post
     *
     * @param Post $_oPost
     * @return boolean
     */
    public function insertPost($_oPost);
}

