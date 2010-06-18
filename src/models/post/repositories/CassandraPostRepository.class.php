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
     * @param integer $_iCount
     * @return array
     */
    public function getLastPosts($_iCount = 10) {
        $cf = $this->getPostsColumnFamily('1');
        $cf->limit(5)->load();
        print_r($cf->toJSON());
    }

    /**
     * @param Post $_oPost
     * @return boolean
     */
    public function insertPost($_oPost) {
       	PandraCore::addLogger('FirePHP');
		// Insert post data
        $oCfPost = $this->getPostsColumnFamily($_oPost->slug);
        $oCfPost->addColumn('slug')->setValue($_oPost->slug);
        $oCfPost->addColumn('title')->setValue($_oPost->title);
		$oCfPost->addColumn('text')->setValue($_oPost->text);
		//$oCfPost->addColumn('tags')->setValue($_oPost->tags);
        $oCfPost->save();
		// Insert post in fake tag entry
        $oCfTagPost = $this->getTagsPostsColumnFamily(CASSANDRA_COLUMNFAMILY_TAGALL);
        $oCfTagPost->addColumn(UUID::v1())->setValue($_oPost->slug);
        $oCfTagPost->save();
		var_dump($oCfTagPost);
		// associate post with tags
        foreach ($_oPost->tags as $sTag) {
            $oCfTagPost = $this->getTagsPostsColumnFamily($sTag);
            $oCfTagPost->addColumn(UUID::v1())->setValue($_oPost->slug);
            $oCfTagPost->save();
        }


        return true;
    }

}

