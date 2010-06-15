<?php

abstract class BaseManager {

    protected $moRepository;

    protected abstract function getRepository();

    protected abstract function setRepository($poRepository);
}

