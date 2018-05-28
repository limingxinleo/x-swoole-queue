<?php
// +----------------------------------------------------------------------
// | TestQueue.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\Test\App;

use Xin\Support\File;
use Xin\Swoole\Queue\Task;

class TestQueue extends Task
{
    // 消息队列Redis键值 list lpush添加队列
    protected $queueKey = 'swoole:queue:queue';
    // 延时消息队列的Redis键值 zset
    protected $delayKey = 'swoole:queue:delay';
    // pid地址
    protected $pidPath = TESTS_PATH . '/queue.pid';

    public $file = TESTS_PATH . '/test.cache';

    protected function handle($recv)
    {
        File::getInstance()->put($this->file, 'upgrade');
    }
}