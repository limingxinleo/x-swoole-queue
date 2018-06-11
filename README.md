# Swoole Queue Library

[![Build Status](https://travis-ci.org/limingxinleo/x-swoole-queue.svg?branch=master)](https://travis-ci.org/limingxinleo/x-swoole-queue)

## 安装
~~~
composer require limingxinleo/x-swoole-queue
~~~

## 基本使用办法
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

## 高级使用办法
实现我们自己的消息队列类
~~~php
<?php
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
~~~

启动我们的消息队列
~~~php
<?php
require __DIR__ . '/bootstrap.php';

use Tests\Test\App\Queue;

$config = include TESTS_PATH . '/_ci/config.php';

$host = $config['redisHost'];
$auth = $config['redisAuth'];
$db = $config['redisDb'];
$port = $config['redisPort'];

$queue = new Queue();
$queue->run();
~~~

载入消费数据
~~~php
<?php
use Tests\Test\App\Queue;
use Xin\Swoole\Queue\JobInterface;

class TestJob implements JobInterface
{
    public $msg;

    public function __construct($msg)
    {
        $this->msg = $msg;
    }

    public function handle()
    {
        echo $this->msg;
    }
}

$job = new TestJob('upgrade by test job, when the queue push it!');
$queue = new Queue();
$queue->push($job);
~~~