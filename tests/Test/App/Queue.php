<?php
// +----------------------------------------------------------------------
// | Queue.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\Test\App;

use Xin\Swoole\Queue\Job;

class Queue extends Job
{
    public function __construct()
    {
        $config = include TESTS_PATH . '/_ci/config.php';

        $host = $config['redisHost'];
        $auth = $config['redisAuth'];
        $db = $config['redisDb'];
        $port = $config['redisPort'];

        $this->setRedisConfig($host, $auth, $db, $port);
        $this->setPidPath(TESTS_PATH . '/queue2.pid');
    }
}
