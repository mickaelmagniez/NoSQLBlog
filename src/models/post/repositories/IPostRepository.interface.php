<?php

interface IPostRepository {

    /**
     * Get last x posts
     *
     * @param integer $_iCount
     * @return array
     */
    public function getLastPosts($_iCount = 10);

	/**
     * Get last x posts by tag
     *
	 * @param string $_sTag
     * @param integer $_iCount
     * @return array
     */
    public function getLastPostsByTag($_sTag, $_iCount = 10);

    /**
     * Insert a new post
     *
     * @param Post $_oPost
     * @return boolean
     */
    public function insertPost($_oPost);
}

