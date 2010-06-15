<?php

interface IPostRepository {

    /**
     * @param integer $_iCount
     * @return array
     */
    public function getLastPosts($_iCount = 10);
}

