<?php

require_once __MODEL_PATH . 'post/repositories/IPostRepository.interface.php';
require_once __MODEL_PATH . 'base/repositories/CassandraRepository.class.php';
require_once __MODEL_PATH . 'post/Post.class.php';

class CassandraPostRepository extends CassandraRepository implements IPostRepository {

	/**
	 * @param string $_sKey
	 * @return PandraColumnFamily
	 */
	private function getPostsColumnFamily($_sKey) {
		return new PandraColumnFamily($_sKey,
		CASSANDRA_KEYSPACE,
		CASSANDRA_COLUMNFAMILY_BLOGENTRIES,
		PandraColumnFamily::TYPE_STRING);
	}

	/**
	 * @param string $_sKey
	 * @return PandraColumnFamily
	 */
	private function getTagsPostsColumnFamily($_sKey) {
		return new PandraColumnFamily($_sKey,
		CASSANDRA_KEYSPACE,
		CASSANDRA_COLUMNFAMILY_TAGSPOSTS,
		PandraColumnFamily::TYPE_UUID);
	}

	/**
	 * @param int $_iCount
	 * @param int $_iPage
	 * @return array
	 */
	public function getLastPosts($_iCount = 5, $_iPage = 1) {
		return $this->getLastPostsByTag(CASSANDRA_COLUMNFAMILY_TAGALL, $_iCount, $_iPage);
	}

	/**
	 * @param string $_sTag
	 * @param int $_iCount
	 * @param int $_iPage
	 * @return array
	 */
	public function getLastPostsByTag($_sTag, $_iCount = 5, $_iPage = 1) {
		$oCfPostTags = $this->getTagsPostsColumnFamily($_sTag);
		@$oCfPostTags->limit($_iCount * $_iPage)->load();
		$aPosts = array();
		// Bad way to paging, must use cassandra slices, but not the purpose
		$aPostsResult = array_splice($oCfPostTags->toArray(), ($_iPage - 1) * $_iCount,$_iCount);
		foreach ($aPostsResult as $sSlug) {
			$oCfPost = $this->getPostsColumnFamily($sSlug);
			$oCfPost->load();
			$oPost = new Post();
			$oPost->slug = $oCfPost['slug'];
			$oPost->title = $oCfPost['title'];
			$oPost->text = $oCfPost['text'];
			$oPost->tags = explode(',', $oCfPost['tags']);
			$aPosts[] = $oPost;
		}
		return $aPosts;
	}

	/**
	 * @param Post $_oPost
	 * @return boolean
	 */
	public function insertPost($_oPost) {
		// Insert post data
		$oCfPost = $this->getPostsColumnFamily($_oPost->slug);
		$oCfPost->addColumn('slug')->setValue($_oPost->slug);
		$oCfPost->addColumn('title')->setValue($_oPost->title);
		$oCfPost->addColumn('text')->setValue($_oPost->text);
		$oCfPost->addColumn('tags')->setValue(implode(',', $_oPost->tags));
		$oCfPost->save();
		// Insert post in fake tag entry
		$oCfTagPost = $this->getTagsPostsColumnFamily(CASSANDRA_COLUMNFAMILY_TAGALL);
		$oCfTagPost->addColumn(UUID::v1())->setValue($_oPost->slug);
		$oCfTagPost->save();

		// associate post with tags
		foreach ($_oPost->tags as $sTag) {
			$oCfTagPost = $this->getTagsPostsColumnFamily($sTag);
			$oCfTagPost->addColumn(UUID::v1())->setValue($_oPost->slug);
			$oCfTagPost->save();
		}


		return true;
	}

}

