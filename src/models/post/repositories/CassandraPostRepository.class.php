<?php

require_once __MODEL_PATH . 'post/repositories/IPostRepository.interface.php';
require_once __MODEL_PATH . 'base/repositories/CassandraRepository.class.php';
require_once __MODEL_PATH . 'post/Post.class.php';

class CassandraPostRepository extends CassandraRepository implements IPostRepository {

    /**
     * @param integer $_iCount
     * @return array
     */
    public function getLastPosts($_iCount = 10) {
        return array();
    }

}

