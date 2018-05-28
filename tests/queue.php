<?php
// +----------------------------------------------------------------------
// | server.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
require __DIR__ . '/bootstrap.php';

use Tests\Test\App\TestQueue;

$config = include TESTS_PATH . '/_ci/config.php';

$queue = new TestQueue();
$queue->setRedisConfig($config['redisHost'], $config['redisAuth'], $config['redisDb'], $config['redisPort']);
$queue->run();
