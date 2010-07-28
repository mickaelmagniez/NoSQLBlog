<?php

require_once __CONF_PATH . 'storage/redis/Redis.conf.php';

abstract class RedisRepository {
	
	protected $moClient;

	public function __construct() {
		$this->moClient = new Redis();
		$this->moClient->connect(REDIS_SERVER, REDIS_PORT);
	}

	public function __destruct() {
	}
}