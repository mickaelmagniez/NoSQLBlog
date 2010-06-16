<?php

require_once __MODEL_PATH . 'post/repositories/IPostRepository.interface.php';
require_once __MODEL_PATH . 'base/repositories/CassandraRepository.class.php';
require_once __MODEL_PATH . 'post/Post.class.php';

class CassandraPostRepository extends CassandraRepository implements IPostRepository {

    /**
     * @param string $_sKey
     * @return PandraColumnFamily
     */
    private function getColumnFamily($_sKey) {
        return new PandraColumnFamily($_sKey,
                CASSANDRA_KEYSPACE,
                CASSANDRA_COLUMNFAMILY_BLOGENTRIES,
                PandraColumnFamily::TYPE_STRING);
    }

    /**
     * @param integer $_iCount
     * @return array
     */
    public function getLastPosts($_iCount = 10) {
        $cf = $this->getColumnFamily('1');
        $cf->limit(5)->load();
        print_r($cf->toJSON());
    }

    /**
     * @param Post $_oPost
     * @return boolean
     */
    public function insertPost($_oPost) {
        $cf = $this->getColumnFamily($_oPost->slug);
		$cf->addColumn('slug')->setValue($_oPost->slug);
		$cf->addColumn('title')->setValue($_oPost->title);
        $cf->save();
		return true;
    }

}

