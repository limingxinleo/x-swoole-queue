<?php
// +----------------------------------------------------------------------
// | server.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
require __DIR__ . '/bootstrap.php';

use Xin\Swoole\Queue\Job;

$config = include TESTS_PATH . '/_ci/config.php';

$host = $config['redisHost'];
$auth = $config['redisAuth'];
$db = $config['redisDb'];
$port = $config['redisPort'];

$queue = new Job();
$queue->setRedisConfig($host, $auth, $db, $port)
    ->setPidPath(TESTS_PATH . 'queue2.pid')
    ->run();
