<?php

require_once __CONF_PATH . 'storage/redis/Redis.conf.php';

abstract class RedisRepository {

	public function __construct() {
	}

	public function __destruct() {
	}
}