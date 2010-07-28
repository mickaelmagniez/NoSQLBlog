<?php

require_once __MODEL_PATH . 'base/BaseManager.class.php';
require_once __MODEL_PATH . 'post/Post.class.php';
require_once __MODEL_PATH . 'post/repositories/DefaultPostRepository.class.php';

class Postmanager extends BaseManager {

	/**
	 * @param int $_iCount
	 * @param int $_iPage
	 * @return array
	 */
	public function getLastPosts($_iCount = 5, $_iPage = 1) {
		return $this->getRepository()->getLastPosts($_iCount, $_iPage);
	}

	/**
	 * @param string $_sTag
	 * @param int $_iCount
	 * @param int $_iPage
	 * @return array
	 */
	public function getLastPostsByTag($_sTag, $_iCount = 5, $_iPage = 1) {
		return $this->getRepository()->getLastPostsByTag($_sTag, $_iCount, $_iPage);
	}

	/**
	 * @param string $_sTitle
	 * @param string $_sText
	 * @param string $_sTags
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
	 * @return iPostRepository
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

