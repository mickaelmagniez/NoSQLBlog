<?php

require_once __MODEL_PATH . 'post/repositories/IPostRepository.interface.php';
require_once __MODEL_PATH . 'base/repositories/RedisRepository.class.php';

class RedisPostRepository extends RedisRepository implements IPostRepository {

	const KEY_SEP = ':';
	const KEYPREFIX_POST = 'post';
	const KEYPREFIX_TAGPOST = 'tagpost';
	const KEY_ALLPOSTS = 'allposts';

	public function __construct() {
		parent::__construct();
	}

	/**
	 * @param string $_sSlug
	 * @return string
	 */
	private function generatePostKey($_sSlug){
		return self::KEYPREFIX_POST . self::KEY_SEP .$_sSlug;
	}

	/**
	 *
	 * @param string $_sSlug
	 * @return Post
	 */
	public function getPost($_sSlug) {
		$aPost = $this->moClient->hGetAll($this->generatePostKey($_sSlug));
		$oPost = new Post();
		$oPost->slug = $aPost['slug'];
		$oPost->title = $aPost['title'];
		$oPost->text = $aPost['text'];
		$oPost->tags = $this->moClient->lGetRange($this->generatePostKey($_sSlug) . self::KEY_SEP . 'tags', 0, 10);
		return $oPost;
	}


	/**
	 * @param int $_iCount
	 * @param int $_iPage
	 * @return array
	 */
	public function getLastPosts($_iCount = 5, $_iPage = 1) {
		return $this->getLastPostsByTag(self::KEY_ALLPOSTS, $_iCount, $_iPage);
	}

	/**
	 * @param string $_sTag
	 * @param int $_iCount
	 * @param int $_iPage
	 * @return array
	 */
	public function getLastPostsByTag($_sTag, $_iCount = 5, $_iPage = 1) {
		$aPosts = array();
		$aSlugs = $this->moClient->lGetRange(self::KEYPREFIX_TAGPOST.  self::KEY_SEP . $_sTag, ($_iPage - 1) * $_iCount,$_iPage * $_iCount);
		foreach($aSlugs as $sSlug) {
			$aPosts[] = $this->getPost($sSlug);
		}
		return $aPosts;
	}

	/**
	 * @param Post $_oPost
	 * @return boolean
	 */
	public function insertPost($_oPost) {
		$sPostKey = $this->generatePostKey($_oPost->slug);
		if ($this->moClient->exists($sPostKey) === false) {
			$this->moClient->hMset($sPostKey, array('slug'=> $_oPost->slug, 'title'=> $_oPost->title, 'text'=> $_oPost->text));
			$this->moClient->delete($sPostKey .  self::KEY_SEP . 'tags');
			foreach ($_oPost->tags as $sTag) {
				$this->moClient->rPush($sPostKey .  self::KEY_SEP . 'tags', $sTag);
				$this->moClient->lPush(self::KEYPREFIX_TAGPOST.  self::KEY_SEP . $sTag, $_oPost->slug);
			}
			$this->moClient->lPush(self::KEYPREFIX_TAGPOST.  self::KEY_SEP . self::KEY_ALLPOSTS, $_oPost->slug);

			return true;
		} else {
			return false;
		}
	}

}

