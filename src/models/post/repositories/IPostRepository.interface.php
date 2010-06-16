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
     * Insert a new post
     *
     * @param Post $_oPost
     * @return boolean
     */
    public function insertPost($_oPost);
}

