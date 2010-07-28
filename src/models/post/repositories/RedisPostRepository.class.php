<?php

require_once __MODEL_PATH . 'post/repositories/IPostRepository.interface.php';
require_once __MODEL_PATH . 'base/repositories/RedisRepository.class.php';

class RedisPostRepository extends RedisRepository implements IPostRepository {

	/**
	 * @param int $_iCount
	 * @param int $_iPage
	 * @return array
	 */
	public function getLastPosts($_iCount = 5, $_iPage = 1) {
		return array();
	}

	/**
	 * @param string $_sTag
	 * @param int $_iCount
	 * @param int $_iPage
	 * @return array
	 */
	public function getLastPostsByTag($_sTag, $_iCount = 5, $_iPage = 1) {
		return array();
	}

	/**
	 * @param Post $_oPost
	 * @return boolean
	 */
	public function insertPost($_oPost) {
		return true;
	}

}

