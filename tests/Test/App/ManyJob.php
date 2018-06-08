<?php
// +----------------------------------------------------------------------
// | TestJob.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\Test\App;

use Xin\Redis;
use Xin\Swoole\Queue\JobInterface;

class ManyJob implements JobInterface
{
    public $key = 'test:incr';

    public function handle()
    {
        $config = include TESTS_PATH . '/_ci/config.php';

        $host = $config['redisHost'];
        $auth = $config['redisAuth'];
        $db = $config['redisDb'];
        $port = $config['redisPort'];

        $redis = Redis::getInstance($host, $auth, $db, $port);
        $redis->incr($this->key);
    }
}