<?php
$memcached = new Memcached();
$memcached->addServer('127.0.0.1', 11211);

if ($memcached->getVersion() === false) {
    die('Failed to connect to Memcached server');
}

$GLOBALS['cache'] = $memcached;