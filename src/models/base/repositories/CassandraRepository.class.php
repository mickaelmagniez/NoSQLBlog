<?php

require_once __LIBRARY_PATH . 'storage/cassandra/pandra/config.php';
require_once __CONF_PATH . 'storage/cassandra/Cassandra.conf.php';

abstract class CassandraRepository {

    public function __construct() {
        PandraCore::Connect('localhost', 'localhost');
    }

    public function __destruct() {
        PandraCore::disconnectAll();
    }

}

