# Swoole Queue Library

[![Build Status](https://travis-ci.org/limingxinleo/x-swoole-queue.svg?branch=master)](https://travis-ci.org/limingxinleo/x-swoole-queue)

## 安装
~~~
composer require limingxinleo/x-swoole-queue
~~~

## 使用
消息队列使用
~~~php
<?php
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
~~~
消息类
~~~php
<?php
namespace Tests\Test\App;

use Xin\Support\File;
use Xin\Swoole\Queue\JobInterface;

class TestJob implements JobInterface
{
    public $data;

    public $file = TESTS_PATH . '/test.cache';

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        File::getInstance()->put($this->file, $this->data);
    }
}
~~~
载入消费队列的方法
~~~php
<?php
use Tests\Test\App\TestJob;
use Xin\Redis;

$redis = Redis::getInstance(); 
$job = new TestJob('upgrade by test job!');
$redis->lPush('swoole:queue:queue', serialize($job));
~~~